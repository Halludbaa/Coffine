<?php

use Hallax\Clone\Services\Hellper;

include __DIR__ . '/../components/header.php';
// Hellper::helldie($data['post']);
?>

<?php
$count = 0;
foreach ($data['post'] as $post):

?>
    <div class="post" id="post<?= $count ?>">
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
                            <li>
                                <a class="danger" onclick="
                                deletePost('<?= BASEURL ?>/post/destroy', '<?= $post['slug'] ?>', '#post<?= $count ?>')
                                ">Delete</a>
                            </li>
                        <?php }  ?>
                    <?php }  ?>
                </ul>
            </details>
        </div>

        <a href="/@<?= $post['username'] ?>/<?= $post['slug'] ?>">
            <p><?= htmlspecialchars($post['body_post']) ?></p>
        </a>
        <?php if (isset($post['media'])): ?>
            <img src="img/uploads/<?= $post['media'] ?>" class="post-img" />
        <?php endif ?>

        <div class="action-group">
            <label for="like<?= $count ?>" class="like">
                <span><?= $post['total_like'] ?></span>
                <input type="checkbox" name="like" id="like<?= $count ?>" class="check-like" <?= $post['is_like'] ? "checked" : "" ?>
                    onchange="sendLike('<?= BASEURL . '/save/like' ?>', '<?= @$_SESSION['user'] ?>', '<?= $post['username'] ?>', '<?= $post['slug'] ?>', this)" />
            </label>
            <label for="save<?= $count ?> class="save">
                <input
                    type="checkbox"
                    name="save"
                    id="save<?= $count ?>"
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


<?php
    $count++;
endforeach;
?>

<?php include __DIR__ . '/../components/footer.php'; ?>