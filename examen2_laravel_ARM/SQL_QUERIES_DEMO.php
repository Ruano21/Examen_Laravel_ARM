<?php

/**
 * DEMOSTRACIÓN DE CONSULTAS SQL
 * 
 * Este archivo muestra las consultas SQL reales que se ejecutan
 * con y sin Eager Loading para demostrar el problema N+1
 */

// ============================================================
// EJEMPLO 1: SIN EAGER LOADING (Problema N+1)
// ============================================================

// Código:
$posts = Post::all();
foreach ($posts as $post) {
    echo $post->user->name;
}

// Consultas SQL ejecutadas:
/*
1. SELECT * FROM posts                          -- 1 query para obtener posts
2. SELECT * FROM users WHERE id = 1             -- 1 query por cada post
3. SELECT * FROM users WHERE id = 2
4. SELECT * FROM users WHERE id = 3
5. SELECT * FROM users WHERE id = 4
...
21. SELECT * FROM users WHERE id = 20           -- Total: 1 + 20 = 21 queries
*/

// ============================================================
// EJEMPLO 2: CON EAGER LOADING (Optimizado)
// ============================================================

// Código:
$posts = Post::with('user')->get();
foreach ($posts as $post) {
    echo $post->user->name;
}

// Consultas SQL ejecutadas:
/*
1. SELECT * FROM posts                          -- 1 query para posts
2. SELECT * FROM users WHERE id IN (1,2,3,4,5,6,7,8,9,10)  -- 1 query para todos los users
                                                -- Total: 2 queries
*/

// ============================================================
// EJEMPLO 3: Posts con Comentarios - SIN EAGER LOADING
// ============================================================

// Código:
$posts = Post::all();
foreach ($posts as $post) {
    echo $post->user->name;
    foreach ($post->comments as $comment) {
        echo $comment->user->name;
    }
}

// Consultas SQL ejecutadas:
/*
1. SELECT * FROM posts                          -- 1 query
2. SELECT * FROM users WHERE id = 1             -- 20 queries (1 por post)
3. SELECT * FROM users WHERE id = 2
...
21. SELECT * FROM users WHERE id = 10

22. SELECT * FROM comments WHERE post_id = 1    -- 20 queries (1 por post)
23. SELECT * FROM comments WHERE post_id = 2
...
41. SELECT * FROM comments WHERE post_id = 20

42. SELECT * FROM users WHERE id = 5            -- 50 queries (1 por comentario)
43. SELECT * FROM users WHERE id = 7
...
91. SELECT * FROM users WHERE id = 8            
                                                -- Total: 1 + 20 + 20 + 50 = 91 queries!
*/

// ============================================================
// EJEMPLO 4: Posts con Comentarios - CON EAGER LOADING
// ============================================================

// Código:
$posts = Post::with(['user', 'comments.user'])->get();
foreach ($posts as $post) {
    echo $post->user->name;
    foreach ($post->comments as $comment) {
        echo $comment->user->name;
    }
}

// Consultas SQL ejecutadas:
/*
1. SELECT * FROM posts                          
2. SELECT * FROM users WHERE id IN (1,2,3,4,5,6,7,8,9,10)
3. SELECT * FROM comments WHERE post_id IN (1,2,3,...,20)
4. SELECT * FROM users WHERE id IN (1,2,3,...,10)
                                                -- Total: 4 queries
*/

// ============================================================
// COMPARACIÓN DE RENDIMIENTO
// ============================================================

/*
Escenario: 20 posts, 10 usuarios, 50 comentarios

Sin Eager Loading:
- Posts con autores: 21 queries
- Posts con autores y comentarios: 91 queries
- Tiempo estimado: ~500ms - 1s

Con Eager Loading:
- Posts con autores: 2 queries
- Posts con autores y comentarios: 4 queries
- Tiempo estimado: ~50ms - 100ms

Mejora de rendimiento: 90-95% más rápido!
*/

// ============================================================
// EJEMPLO 5: withCount - Solo contar sin cargar
// ============================================================

// Código:
$posts = Post::withCount('comments')->with('user')->get();

// Consultas SQL ejecutadas:
/*
1. SELECT posts.*, 
         (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) as comments_count
   FROM posts
2. SELECT * FROM users WHERE id IN (1,2,3,...,10)
                                                -- Total: 2 queries
*/

// ============================================================
// EJEMPLO 6: Eager Loading Condicional
// ============================================================

// Código:
$posts = Post::with(['user', 'comments' => function ($query) {
    $query->latest()->limit(5)->with('user');
}])->get();

// Consultas SQL ejecutadas:
/*
1. SELECT * FROM posts
2. SELECT * FROM users WHERE id IN (1,2,3,...,10)
3. SELECT * FROM (
     SELECT * FROM comments WHERE post_id IN (1,2,3,...,20)
     ORDER BY created_at DESC LIMIT 5
   ) as comments
4. SELECT * FROM users WHERE id IN (...)
                                                -- Total: 4 queries optimizadas
*/

// ============================================================
// BUENAS PRÁCTICAS
// ============================================================

/*
1. SIEMPRE usa Eager Loading cuando accedas a relaciones en loops
2. Usa withCount() si solo necesitas el número de relaciones
3. Carga solo las relaciones que necesitas
4. Usa notación de punto para relaciones anidadas: 'comments.user'
5. Añade condiciones al eager loading para limitar datos cargados
6. Usa lazy eager loading ($model->load()) si no sabes de antemano qué cargar
7. Monitorea queries con Laravel Debugbar o Log
*/

// ============================================================
// CÓMO DETECTAR EL PROBLEMA N+1
// ============================================================

/*
En el archivo .env, activa el log de queries:
DB_LOG_QUERIES=true

O en AppServiceProvider.php:
use Illuminate\Support\Facades\DB;

public function boot()
{
    DB::listen(function($query) {
        logger($query->sql, $query->bindings);
    });
}

Si ves muchas queries similares ejecutándose en un loop, 
probablemente tienes un problema N+1.
*/
