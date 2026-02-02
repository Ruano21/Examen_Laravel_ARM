<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Lista de Posts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 3px solid #4CAF50;
            padding-bottom: 10px;
        }
        .post {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fafafa;
        }
        .post h2 {
            margin-top: 0;
            color: #4CAF50;
        }
        .post h2 a {
            color: #4CAF50;
            text-decoration: none;
        }
        .post h2 a:hover {
            text-decoration: underline;
        }
        .post-info {
            color: #777;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .post-content {
            line-height: 1.6;
            color: #555;
        }
        .comments {
            margin-top: 10px;
            font-weight: bold;
            color: #4CAF50;
        }
        .no-posts {
            text-align: center;
            color: #999;
            padding: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lista de Posts del Blog</h1>

        <?php if($posts->count() > 0): ?>
            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="post">
                    <h2>
                        <a href="<?php echo e(route('posts.show', $post)); ?>"><?php echo e($post->title); ?></a>
                    </h2>
                    
                    <div class="post-info">
                        Autor: <?php echo e($post->user->name); ?> | Fecha: <?php echo e($post->created_at->format('d/m/Y')); ?>

                    </div>

                    <div class="post-content">
                        <?php echo e(Str::limit($post->content, 200)); ?>

                    </div>

                    <div class="comments">
                        💬 <?php echo e($post->comments->count()); ?> comentarios
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="no-posts">
                <p>No hay posts disponibles.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\laravel\examen2_laravel_ARM\resources\views/posts/index.blade.php ENDPATH**/ ?>