<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;

class ARMBlogDemoController extends Controller
{
    /**
     * DEMOSTRACIÓN DE CONSULTAS CON CARGA ANSIOSA (EAGER LOADING)
     * Controlador ARM - Blog Demo
     * 
     * Este controlador muestra diferentes formas de usar eager loading
     * para evitar el problema N+1 y optimizar las consultas a la base de datos.
     */

    /**
     * Ejemplo 1: Obtener posts con sus autores
     * Carga ansiosa de la relación 'user'
     */
    public function postsWithAuthors()
    {
        // Sin eager loading (problema N+1):
        // $posts = Post::all(); // 1 query
        // foreach ($posts as $post) {
        //     echo $post->user->name; // N queries adicionales
        // }

        // Con eager loading (optimizado):
        $posts = Post::with('user')->get(); // Solo 2 queries
        
        return response()->json($posts);
    }

    /**
     * Ejemplo 2: Obtener posts con sus comentarios
     * Carga ansiosa de la relación 'comments'
     */
    public function postsWithComments()
    {
        $posts = Post::with('comments')->get();
        
        return response()->json($posts);
    }

    /**
     * Ejemplo 3: Obtener posts con autores y comentarios
     * Carga ansiosa de múltiples relaciones
     */
    public function postsWithAuthorsAndComments()
    {
        $posts = Post::with(['user', 'comments'])->get();
        
        return response()->json($posts);
    }

    /**
     * Ejemplo 4: Obtener posts con comentarios y autores de los comentarios
     * Carga ansiosa de relaciones anidadas usando notación de punto
     */
    public function postsWithCommentsAndCommentAuthors()
    {
        $posts = Post::with(['user', 'comments.user'])
            ->latest()
            ->get();
        
        return response()->json($posts);
    }

    /**
     * Ejemplo 5: Obtener posts con conteo de comentarios
     * Usa withCount para obtener solo el número de comentarios sin cargar todos los datos
     */
    public function postsWithCommentsCount()
    {
        $posts = Post::withCount('comments')
            ->with('user')
            ->get();
        
        // Cada post tendrá un atributo 'comments_count'
        return response()->json($posts);
    }

    /**
     * Ejemplo 6: Filtrar posts y cargar relaciones
     * Eager loading con condiciones
     */
    public function recentPostsWithData()
    {
        $posts = Post::with(['user', 'comments' => function ($query) {
            // Solo cargar los últimos 5 comentarios de cada post
            $query->latest()->limit(5)->with('user');
        }])
        ->where('created_at', '>=', now()->subDays(30))
        ->latest()
        ->get();
        
        return response()->json($posts);
    }

    /**
     * Ejemplo 7: Obtener usuarios con sus posts y comentarios
     * Eager loading desde el modelo User
     */
    public function usersWithPostsAndComments()
    {
        $users = User::with(['posts', 'comments'])
            ->get();
        
        return response()->json($users);
    }

    /**
     * Ejemplo 8: Carga ansiosa condicional
     * Cargar relaciones solo si se necesitan
     */
    public function postsConditionalLoading($includeComments = true)
    {
        $query = Post::with('user');

        if ($includeComments) {
            $query->with('comments.user');
        }

        $posts = $query->get();
        
        return response()->json($posts);
    }

    /**
     * Ejemplo 9: Lazy Eager Loading
     * Cargar relaciones después de recuperar el modelo
     */
    public function lazyEagerLoading()
    {
        $posts = Post::all();
        
        // Cargar relaciones después si es necesario
        $posts->load(['user', 'comments.user']);
        
        return response()->json($posts);
    }

    /**
     * Ejemplo 10: Eager loading para un solo modelo
     */
    public function showPostWithAllRelations($postId)
    {
        $post = Post::with(['user', 'comments.user'])
            ->findOrFail($postId);
        
        return response()->json($post);
    }
}
