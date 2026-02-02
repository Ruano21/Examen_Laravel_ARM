<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Todos los Posts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        h1 {
            color: #333;
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid #4CAF50;
        }
        .post {
            background-color: white;
            margin-bottom: 30px;
            padding: 25px;
            border-left: 4px solid #4CAF50;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .post-title {
            color: #4CAF50;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .post-meta {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .post-content {
            color: #333;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .comments-section {
            border-top: 1px solid #ddd;
            padding-top: 15px;
            margin-top: 20px;
        }
        .comments-title {
            color: #555;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .comment {
            background-color: #f9f9f9;
            padding: 12px;
            margin-bottom: 10px;
            border-left: 3px solid #4CAF50;
        }
        .comment-author {
            font-weight: bold;
            color: #4CAF50;
            margin-bottom: 5px;
        }
        .comment-content {
            color: #555;
        }
        .no-comments {
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lista de Posts del Blog</h1>

        <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="post">
                <h2 class="post-title"><?php echo e($post->title); ?></h2>
                
                <div class="post-meta">
                    Autor: <?php echo e($post->user->name); ?> | Fecha: <?php echo e($post->created_at->format('d/m/Y')); ?>

                </div>

                <div class="post-content">
                    <?php echo e($post->content); ?>

                </div>

                <div class="comments-section">
                    <div class="comments-title">
                        💬 <?php echo e($post->comments->count()); ?> comentarios
                    </div>

                    <?php if($post->comments->count() > 0): ?>
                        <?php $__currentLoopData = $post->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="comment">
                                <div class="comment-author"><?php echo e($comment->user->name); ?></div>
                                <div class="comment-content"><?php echo e($comment->content); ?></div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <p class="no-comments">No hay comentarios aún.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\laravel\examen2_laravel_ARM\resources\views/posts/all.blade.php ENDPATH**/ ?>