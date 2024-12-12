
<?php

use Hallax\Clone\Services\Hellper;

 include __DIR__ . '/../components/header.php'; ?>

<?php $opt = $data['options']; 
// Hellper::helldie($opt);
?>
<form action="#" enctype="multipart/form-data" id="optionForm" method="post">
    <div class="wrapper-options">
        <input type="hidden" name="old_photo" id="old" value="<?= $opt['photo_profile'] ?>" />
        <div class="media-wrapper">
            <label for="profile">
                Change Photo
            </label>
            <input
                    type="file"
                    name="profile"
                    id="profile"
                    accept="image/*"
                    onchange="WillUpload(this, '#showImage')" />
            <img src="img/uploads/<?= $opt['photo_profile'] ?? 'none.jpg' ?>" alt="Hello" id="showImage" width="200" />
        </div>
        <label for="display">Name :
            <input
                
                type="text"
                name="display"
                id="display"
                value="<?= $opt['display_name'] ?>"
                placeholder="Display Name" />
        </label>
        <button type="button" class="btn" onclick="saveProfile('<?= BASEURL ?>/save/profile', '<?= $opt['username'] ?>')">Save</button>
    </div>

</form>



<?php include __DIR__ . '/../components/footer.php'; ?>
