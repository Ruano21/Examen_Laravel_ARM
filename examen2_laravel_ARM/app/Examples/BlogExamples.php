<?php

/**
 * EJEMPLOS PRÁCTICOS DE USO DEL SISTEMA DE BLOG ARM
 * Autor: ARM
 * 
 * Este archivo muestra cómo utilizar el sistema de blog
 * con ejemplos de código listos para usar.
 */

namespace App\Examples;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class ARMBlogExamples
{
    /**
     * EJEMPLO 1: Crear un nuevo post
     */
    public function createPost()
    {
        $user = User::first();

        $post = Post::create([
            'user_id' => $user->id,
            'title' => 'Mi primer post',
            'content' => 'Este es el contenido de mi primer post en el blog.',
        ]);

        return $post;
    }

    /**
     * EJEMPLO 2: Crear un comentario en un post
     */
    public function createComment()
    {
        $post = Post::first();
        $user = User::find(2);

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'content' => '¡Excelente post! Me gustó mucho.',
        ]);

        return $comment;
    }

    /**
     * EJEMPLO 3: Obtener todos los posts de un usuario
     */
    public function getUserPosts($userId)
    {
        $user = User::with('posts')->find($userId);
        
        return $user->posts;
    }

    /**
     * EJEMPLO 4: Obtener todos los comentarios de un usuario
     */
    public function getUserComments($userId)
    {
        $user = User::with('comments.post')->find($userId);
        
        return $user->comments;
    }

    /**
     * EJEMPLO 5: Obtener posts con más comentarios
     */
    public function getPostsWithMostComments($limit = 5)
    {
        return Post::withCount('comments')
            ->with('user')
            ->orderBy('comments_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * EJEMPLO 6: Obtener posts recientes con eager loading
     */
    public function getRecentPosts($days = 7)
    {
        return Post::with(['user', 'comments.user'])
            ->where('created_at', '>=', now()->subDays($days))
            ->latest()
            ->get();
    }

    /**
     * EJEMPLO 7: Buscar posts por título
     */
    public function searchPosts($keyword)
    {
        return Post::with('user')
            ->where('title', 'like', "%{$keyword}%")
            ->orWhere('content', 'like', "%{$keyword}%")
            ->get();
    }

    /**
     * EJEMPLO 8: Obtener estadísticas de un usuario
     */
    public function getUserStats($userId)
    {
        $user = User::withCount(['posts', 'comments'])->find($userId);

        return [
            'name' => $user->name,
            'posts_count' => $user->posts_count,
            'comments_count' => $user->comments_count,
            'member_since' => $user->created_at->format('d/m/Y'),
        ];
    }

    /**
     * EJEMPLO 9: Obtener posts sin comentarios
     */
    public function getPostsWithoutComments()
    {
        return Post::with('user')
            ->doesntHave('comments')
            ->get();
    }

    /**
     * EJEMPLO 10: Obtener posts con al menos N comentarios
     */
    public function getPostsWithMinComments($minComments = 3)
    {
        return Post::with(['user', 'comments'])
            ->has('comments', '>=', $minComments)
            ->get();
    }

    /**
     * EJEMPLO 11: Eliminar un post (cascade eliminará comentarios)
     */
    public function deletePost($postId)
    {
        $post = Post::find($postId);
        
        // Gracias a onDelete('cascade'), los comentarios se eliminarán automáticamente
        $post->delete();
    }

    /**
     * EJEMPLO 12: Actualizar un post
     */
    public function updatePost($postId, $data)
    {
        $post = Post::find($postId);
        
        $post->update([
            'title' => $data['title'] ?? $post->title,
            'content' => $data['content'] ?? $post->content,
        ]);

        return $post;
    }

    /**
     * EJEMPLO 13: Obtener comentarios más recientes de un post
     */
    public function getRecentPostComments($postId, $limit = 5)
    {
        $post = Post::with(['comments' => function ($query) use ($limit) {
            $query->latest()->limit($limit)->with('user');
        }])->find($postId);

        return $post->comments;
    }

    /**
     * EJEMPLO 14: Crear post con relación inversa
     */
    public function createPostFromUser()
    {
        $user = User::first();

        // Usando la relación desde el usuario
        $post = $user->posts()->create([
            'title' => 'Post creado desde usuario',
            'content' => 'Este post fue creado usando la relación posts() del usuario.',
        ]);

        return $post;
    }

    /**
     * EJEMPLO 15: Crear comentario usando relación
     */
    public function createCommentFromPost()
    {
        $post = Post::first();
        $user = User::find(2);

        // Usando la relación desde el post
        $comment = $post->comments()->create([
            'user_id' => $user->id,
            'content' => 'Comentario creado usando relación del post.',
        ]);

        return $comment;
    }

    /**
     * EJEMPLO 16: Paginación con eager loading
     */
    public function getPaginatedPosts($perPage = 10)
    {
        return Post::with(['user', 'comments.user'])
            ->latest()
            ->paginate($perPage);
    }

    /**
     * EJEMPLO 17: Contar total de posts y comentarios
     */
    public function getTotalStats()
    {
        return [
            'total_users' => User::count(),
            'total_posts' => Post::count(),
            'total_comments' => Comment::count(),
            'avg_comments_per_post' => Comment::count() / Post::count(),
        ];
    }

    /**
     * EJEMPLO 18: Obtener usuarios más activos (más posts)
     */
    public function getMostActiveUsers($limit = 5)
    {
        return User::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * EJEMPLO 19: Verificar si un usuario ha comentado en un post
     */
    public function hasUserCommented($userId, $postId)
    {
        return Comment::where('user_id', $userId)
            ->where('post_id', $postId)
            ->exists();
    }

    /**
     * EJEMPLO 20: Obtener todos los datos de un post de forma eficiente
     */
    public function getCompletePost($postId)
    {
        return Post::with([
            'user',                    // Autor del post
            'comments.user',           // Comentarios con sus autores
            'comments' => function ($query) {
                $query->latest();      // Ordenar comentarios por más recientes
            }
        ])
        ->withCount('comments')        // Contar comentarios
        ->findOrFail($postId);
    }
}

/**
 * USO EN CONTROLADORES:
 * 
 * public function index()
 * {
 *     $examples = new BlogExamples();
 *     $posts = $examples->getRecentPosts(30);
 *     return view('posts.index', compact('posts'));
 * }
 */

/**
 * USO EN RUTAS (routes/web.php):
 * 
 * Route::get('/examples/stats', function() {
 *     $examples = new BlogExamples();
 *     return $examples->getTotalStats();
 * });
 */

/**
 * USO EN TINKER:
 * 
 * php artisan tinker
 * >>> $examples = new App\Examples\BlogExamples();
 * >>> $posts = $examples->getRecentPosts(7);
 * >>> $stats = $examples->getTotalStats();
 */
