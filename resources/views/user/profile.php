
<?php include __DIR__ . '/../components/header.php'; ?>
<?php $profile = $data['profile'];
use Hallax\Clone\Services\Hellper;
// Hellper::helldie($data);
?>
<!-- <div class="profiles-wrapper"> -->
    <div class="profiles">
        <img src="img/uploads/<?= $profile['photo_profile'] ?? 'none.jpg' ?>" alt="" />
        <div class="text-profile">
            <span class="main"><?= $profile['display_name'] ?? $profile['username'] ?> <svg
                    class="badge"
                    xmlns="http://www.w3.org/2000/svg"
                    width="40"
                    height="40"
                    viewBox="0 0 24 24">
                    <path
                        d="M19.965 8.521C19.988 8.347 20 8.173 20 8c0-2.379-2.143-4.288-4.521-3.965C14.786 2.802 13.466 2 12 2s-2.786.802-3.479 2.035C6.138 3.712 4 5.621 4 8c0 .173.012.347.035.521C2.802 9.215 2 10.535 2 12s.802 2.785 2.035 3.479A3.976 3.976 0 0 0 4 16c0 2.379 2.138 4.283 4.521 3.965C9.214 21.198 10.534 22 12 22s2.786-.802 3.479-2.035C17.857 20.283 20 18.379 20 16c0-.173-.012-.347-.035-.521C21.198 14.785 22 13.465 22 12s-.802-2.785-2.035-3.479zm-9.01 7.895-3.667-3.714 1.424-1.404 2.257 2.286 4.327-4.294 1.408 1.42-5.749 5.706z" />
                </svg></span>
                 <span>@<?= $profile['username'] ?></span>
        </div>
        <?php if($profile['username'] !== @$_SESSION['user']){ ?>
        <button class="
        <?php if(isset($profile) && $profile['is_following']): ?>
            following
        <?php endif; ?>
        " 
        onclick="follow('<?= BASEURL ?>/save/follow', '<?= $profile['username'] ?>', '<?= @$_SESSION['user'] ?>', this)">
        <?= $profile['is_following'] ? "Following" : "Follow" ?></button>
        <?php } ?>
    </div>
<!-- </div> -->
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
            <p><?= $post['body_post'] ?></p>
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
            <label for="save<?= $count ?>" class="save">
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
        </div>
    </div>


<?php
    $count++;
endforeach;
?>





<?php include __DIR__ . '/../components/footer.php'; ?>