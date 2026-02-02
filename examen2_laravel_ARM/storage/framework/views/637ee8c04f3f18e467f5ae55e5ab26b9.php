<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($post->title); ?> - Blog ARM</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        .back-link {
            display: inline-block;
            color: white;
            text-decoration: none;
            margin-bottom: 20px;
            font-size: 1.1em;
            transition: opacity 0.3s;
        }
        .back-link:hover {
            opacity: 0.8;
        }
        .post-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 30px;
        }
        .post-header {
            border-bottom: 3px solid #667eea;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }
        .post-title {
            font-size: 2.5em;
            color: #333;
            margin-bottom: 15px;
            line-height: 1.2;
        }
        .post-meta {
            display: flex;
            gap: 20px;
            color: #666;
            font-size: 1.1em;
        }
        .author {
            font-weight: 600;
        }
        .date {
            color: #999;
        }
        .post-content {
            color: #444;
            line-height: 1.8;
            font-size: 1.1em;
            margin-bottom: 30px;
        }
        .comments-section {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .comments-header {
            font-size: 2em;
            color: #333;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #667eea;
        }
        .comment {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            transition: transform 0.2s;
        }
        .comment:hover {
            transform: translateX(5px);
        }
        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .comment-author {
            font-weight: 600;
            color: #667eea;
            font-size: 1.1em;
        }
        .comment-date {
            color: #999;
            font-size: 0.9em;
        }
        .comment-content {
            color: #555;
            line-height: 1.6;
        }
        .no-comments {
            text-align: center;
            color: #999;
            padding: 40px;
            background: #f8f9fa;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="<?php echo e(route('posts.index')); ?>" class="back-link">← Volver a todos los posts</a>

        <div class="post-card">
            <div class="post-header">
                <h1 class="post-title"><?php echo e($post->title); ?></h1>
                <div class="post-meta">
                    <span class="author">👤 <?php echo e($post->user->name); ?></span>
                    <span class="date">📅 <?php echo e($post->created_at->format('d/m/Y H:i')); ?></span>
                </div>
            </div>
            
            <div class="post-content">
                <?php echo e($post->content); ?>

            </div>
        </div>

        <div class="comments-section">
            <h2 class="comments-header">
                💬 Comentarios (<?php echo e($post->comments->count()); ?>)
            </h2>

            <?php if($post->comments->count() > 0): ?>
                <?php $__currentLoopData = $post->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="comment">
                        <div class="comment-header">
                            <span class="comment-author"><?php echo e($comment->user->name); ?></span>
                            <span class="comment-date"><?php echo e($comment->created_at->diffForHumans()); ?></span>
                        </div>
                        <div class="comment-content">
                            <?php echo e($comment->content); ?>

                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="no-comments">
                    <p>No hay comentarios todavía. ¡Sé el primero en comentar!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\laravel\examen2_laravel_ARM\resources\views/posts/show.blade.php ENDPATH**/ ?>