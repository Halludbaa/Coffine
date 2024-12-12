<?php include __DIR__ . '/../components/header.php'; ?>
<?php $post = $data['post'] ?>
<?php $comments  = $data['comment'] ?>
<div class="post" id="post">
    <div class="info-wrapper">
        <a href="/@<?= $post['username'] ?>">
            <img src="img/uploads/<?= $post['pp'] ?? 'none.jpg' ?>" alt="" />
            <h4><?= htmlspecialchars($post['display_name']) ?></h4>
        </a>
        <!-- <button class="btn">Follow</button> -->
        <details>
            <summary>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24">
                    <path
                        d="M12 10c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm6 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM6 10c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                </svg>
            </summary>
            <ul>
                <?php if ($_SESSION['user'] !== $post['username']) { ?>
                    <li>
                        <a onclick="return prompt('Report')" class="danger">Report</a>
                    </li>
                <?php }  ?>
                <?php if ($_SESSION['user'] == $post['username']) { ?>
                    <?php if ($_SESSION['user'] == $post['username']) { ?>
                        <li>
                            <a href="">Edit</a>
                        </li>
                        <!-- <li>
                            <a class="danger" onclick="
                                deletePost('<?= BASEURL ?>/post/destroy', '<?= $post['slug'] ?>', '#post')
                                ">Delete</a>
                        </li> -->
                    <?php }  ?>
                <?php }  ?>
            </ul>
        </details>
    </div>

    <a href="/@<?= $post['username'] ?>/<?= $post['slug'] ?>">
        <p><?= $post['body_post'] ?></p>
    </a>
    <?php if (isset($post['media'])): ?>
        <img src="img/uploads/<?= $post['media'] ?>" class="post-img" />
    <?php endif ?>

    <div class="action-group">
        <label for="like" class="like">
            <span><?= $post['total_like'] ?></span>
            <input type="checkbox" name="like" id="like" class="check-like" <?= $post['is_like'] ? "checked" : "" ?>
                onchange="sendLike('<?= BASEURL . '/save/like' ?>', '<?= @$_SESSION['user'] ?>', '<?= $post['username'] ?>', '<?= $post['slug'] ?>', this)" />
        </label>
        <label for="save" class="save">
            <input
                type="checkbox"
                name="save"
                id="save"
                class="check-save"
                <?= $post['is_save'] ? "checked" : "" ?>
                onchange="sendSave('<?= BASEURL . '/create/save' ?>', '<?= @$_SESSION['user'] ?>', '<?= $post['username'] ?>', '<?= $post['slug'] ?>', this)" />
        </label>

        <a href="#">
            <button class="share"></button>
        </a>

        <a href="/@<?= $post['username'] ?>/<?= $post['slug'] ?>">
            <button class="comment"></button>
        </a>
    </div>
</div>

<!-- Comment Section  -->
<div class="post">
    <div class="info-wrapper">
        <a onclick="return false">
            <img src="img/uploads/<?= $data['pic'] ?? 'none.jpg' ?>" alt="" />
            <h4><?= htmlspecialchars($data['user']) ?></h4>
        </a>
    </div>
    <div class="form-area">
        <form action="" onsubmit="return false" id="replyForm">
            <img src="#" alt="" id="reply-media-view">
            <textarea name="body-post" id="body-post" placeholder="Write Something..." class="post-textarea" required></textarea>
            <input type="file" name="media" id="reply-media" accept="image/*" onchange="WillUpload(this, '#reply-media-view')" />
            <div class="wrapper-action-reply">
                <label for="reply-media" class="image-label">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="30"
                        height="30"
                        viewBox="0 0 24 24">
                        <path
                            d="M19 3H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2zM5 19V5h14l.002 14H5z" />
                        <path d="m10 14-1-1-3 4h12l-5-7z" />
                    </svg>
                </label>
                <button type="button" onclick="sendReply(this, '<?= $post['slug'] ?>')" class="btn-send">
                    POST
                </button>
            </div>
        </form>
    </div>
</div>
<?php if ($comments == []): ?>
    <div class="text-mid alert-post  height-50">
        No One Comment IN This Post
    </div>
<?php endif; ?>

<?php
$count = 0;
foreach ($comments as $comment): ?>
    <div class="post" id="comment<?= $count ?>">
        <div class="info-wrapper">
            <a href="/@<?= $comment['username'] ?>">
                <img src="img/uploads/<?= $comment['pp'] ?? 'none.jpg' ?>" alt="" />
                <h4><?= htmlspecialchars($comment['display_name']) ?></h4>
            </a>
            <!-- <button class="btn">Follow</button> -->
            <details>
                <summary>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24">
                        <path
                            d="M12 10c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm6 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM6 10c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                    </svg>
                </summary>
                <ul>
                    <?php if ($_SESSION['user'] !== $comment['username']) { ?>
                        <li>
                            <a onclick="return prompt('Report')" class="danger">Report</a>
                        </li>
                    <?php }  ?>
                    <?php if ($_SESSION['user'] == $comment['username']) { ?>
                        <?php if ($_SESSION['user'] == $comment['username']) { ?>
                            <li>
                                <a href="">Edit</a>
                            </li>
                            <li>
                                <a class="danger" onclick="deletePost('/post/destroy', '<?= $comment['slug'] ?>', '#comment<?= $count ?>')
                                ">Delete</a>
                            </li>
                        <?php }  ?>
                    <?php }  ?>
                </ul>
            </details>
        </div>

        <a href="/@<?= $comment['username'] ?>/<?= $comment['slug'] ?>">
            <p><?= $comment['body_post'] ?></p>
        </a>
        <?php if (isset($comment['media'])): ?>
            <img src="img/uploads/<?= $comment['media'] ?>" class="post-img" />
        <?php endif ?>

        <div class="action-group">
            <label for="like<?= $count ?>" class="like">
                <span><?= $comment['total_like'] ?></span>
                <input type="checkbox" name="like" id="like<?= $count ?>" class="check-like" <?= $comment['is_like'] ? "checked" : "" ?>
                    onchange="sendLike('<?= BASEURL . '/save/like' ?>', '<?= @$_SESSION['user'] ?>', '<?= $comment['username'] ?>', '<?= $comment['slug'] ?>', this)" />
            </label>
            <label for="save<?= $count ?>" class="save">
                <input
                    type="checkbox"
                    name="save"
                    id="save<?= $count ?>"
                    class="check-save"
                    <?= $comment['is_save'] ? "checked" : "" ?>
                    onchange="sendSave('<?= BASEURL . '/create/save' ?>', '<?= @$_SESSION['user'] ?>', '<?= $comment['username'] ?>', '<?= $comment['slug'] ?>', this)" />
            </label>

            <a href="#">
                <button class="share"></button>
            </a>

        <a href="/@<?= $comment['username'] ?>/<?= $comment['slug'] ?>">
            <button class="comment"></button>
        </a>
        </div>

    </div>
<?php endforeach; ?>
<?php include __DIR__ . '/../components/footer.php'; ?>