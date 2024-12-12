<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?></title>
    <link rel="shortcut icon" href="icon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <dialog class="modals-post" id="edit-modals">
        <div class="modals-content">
            <form action="/post/patch" enctype="multipart/form-data" method="post" id="editForm" onsubmit="sendEdit(this); return false">
                <div class="input-wrapper">
                    <textarea
                        required
                        name="body-post"
                        id="body-post-edit"
                        class="body-post"
                        placeholder="Write something..." oninput="grow(this)" ></textarea>
                    <input type="file" name="media" id="media-edit" accept="image/*" onchange="WillUpload(this, '#media-view-edit')   " />
                    <input type="hidden" name="old_media" id="old-media-edit">
                    <input type="hidden" name="slug" id="slug-edit">
                    <img src="#" alt="" id="media-view-edit">
                </div>

                <div class="wrapper-action">
                    <label for="media-edit">
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
                    <button type="submit" class="btn-send">
                        Save
                    </button>
                    <button type="button" class="btn bg-red none" onclick="resetFile('#media-edit', '#media-view-edit', true)" id="reset-edit-media">Reset Image</button>

                </div>



            </form>
        </div>
    </dialog>

    <dialog class="modals-post" id="post-modals">
        <div class="modals-content">
            <form action="/post/create" enctype="multipart/form-data" method="post" id="postForm" onsubmit="return false">



                <div class="input-wrapper">

                    <textarea
                        required
                        name="body-post"
                        id="body-post"
                        class="body-post"
                        placeholder="Write something..." oninput="grow(this)"></textarea>
                    <input type="file" name="media" id="media" accept="image/*" onchange="WillUpload(this, '#media-view')   " />
                    <img src="#" alt="" id="media-view">
                </div>
                <div class="wrapper-action">
                    <label for="media">
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
                    <button type="button" onclick="sendPost('<?= BASEURL . '/post/create' ?>', this)" class="btn-send">
                        POST
                    </button>
                    <button type="button" class="btn bg-red none" onclick="resetFile('#media', '#media-view')" id="reset-media">Reset Image</button>
                </div>

            </form>
        </div>
    </dialog>

    <aside class="left">
        <div class="left-content">
            <div class="logo">
                <span>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="30"
                        height="30"
                        viewBox="0 0 24 24">
                        <path
                            d="M6 18a6.06 6.06 0 0 0 5.17-6 7.62 7.62 0 0 1 6.52-7.51l2.59-.37c-.07-.08-.13-.16-.21-.24-3.26-3.26-9.52-2.28-14 2.18C2.28 9.9 1 15 2.76 18.46z" />
                        <path
                            d="M12.73 12a7.63 7.63 0 0 1-6.51 7.52l-2.46.35.15.17c3.26 3.26 9.52 2.29 14-2.17C21.68 14.11 23 9 21.25 5.59l-3.34.48A6.05 6.05 0 0 0 12.73 12z" />
                    </svg>
                </span>
                <h1>COFFINE</h1>
            </div>
            <ul class="navigate">
                <li>
                    <a href="/">
                        <span>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="40px"
                                height="40px"
                                viewBox="0 0 24 24"
                                style="fill: rgba(0, 0, 0, 1)">
                                <path
                                    d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13zm7 7v-5h4v5h-4zm2-15.586 6 6V15l.001 5H16v-5c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H6v-9.586l6-6z"></path>
                            </svg></span></a><a href="/" class="desc"> Home</a>
                </li>
                <li>
                    <a href="/media">
                        <span>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="40px"
                                height="40px"
                                viewBox="0 0 24 24"
                                style="fill: rgba(0, 0, 0, 1)">
                                <path
                                    d="m12 3.879-7.061 7.06 2.122 2.122L12 8.121l4.939 4.94 2.122-2.122z"></path>
                                <path
                                    d="m4.939 17.939 2.122 2.122L12 15.121l4.939 4.94 2.122-2.122L12 10.879z"></path>
                            </svg></span></a><a href="/media" class="desc"> Media</a>
                </li>
                <li>
                    <a href="#">
                        <span>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="35px"
                                height="35px"
                                viewBox="0 0 24 24">
                                <path
                                    d="M18 2H6c-1.103 0-2 .897-2 2v18l8-4.572L20 22V4c0-1.103-.897-2-2-2zm0 16.553-6-3.428-6 3.428V4h12v14.553z" />
                            </svg></span></a><a href="/save" class="desc"> Save</a>
                </li>

                <li>
                    <a href="/options">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 24 24">
                                <path d="M12 16c2.206 0 4-1.794 4-4s-1.794-4-4-4-4 1.794-4 4 1.794 4 4 4zm0-6c1.084 0 2 .916 2 2s-.916 2-2 2-2-.916-2-2 .916-2 2-2z" />
                                <path d="m2.845 16.136 1 1.73c.531.917 1.809 1.261 2.73.73l.529-.306A8.1 8.1 0 0 0 9 19.402V20c0 1.103.897 2 2 2h2c1.103 0 2-.897 2-2v-.598a8.132 8.132 0 0 0 1.896-1.111l.529.306c.923.53 2.198.188 2.731-.731l.999-1.729a2.001 2.001 0 0 0-.731-2.732l-.505-.292a7.718 7.718 0 0 0 0-2.224l.505-.292a2.002 2.002 0 0 0 .731-2.732l-.999-1.729c-.531-.92-1.808-1.265-2.731-.732l-.529.306A8.1 8.1 0 0 0 15 4.598V4c0-1.103-.897-2-2-2h-2c-1.103 0-2 .897-2 2v.598a8.132 8.132 0 0 0-1.896 1.111l-.529-.306c-.924-.531-2.2-.187-2.731.732l-.999 1.729a2.001 2.001 0 0 0 .731 2.732l.505.292a7.683 7.683 0 0 0 0 2.223l-.505.292a2.003 2.003 0 0 0-.731 2.733zm3.326-2.758A5.703 5.703 0 0 1 6 12c0-.462.058-.926.17-1.378a.999.999 0 0 0-.47-1.108l-1.123-.65.998-1.729 1.145.662a.997.997 0 0 0 1.188-.142 6.071 6.071 0 0 1 2.384-1.399A1 1 0 0 0 11 5.3V4h2v1.3a1 1 0 0 0 .708.956 6.083 6.083 0 0 1 2.384 1.399.999.999 0 0 0 1.188.142l1.144-.661 1 1.729-1.124.649a1 1 0 0 0-.47 1.108c.112.452.17.916.17 1.378 0 .461-.058.925-.171 1.378a1 1 0 0 0 .471 1.108l1.123.649-.998 1.729-1.145-.661a.996.996 0 0 0-1.188.142 6.071 6.071 0 0 1-2.384 1.399A1 1 0 0 0 13 18.7l.002 1.3H11v-1.3a1 1 0 0 0-.708-.956 6.083 6.083 0 0 1-2.384-1.399.992.992 0 0 0-1.188-.141l-1.144.662-1-1.729 1.124-.651a1 1 0 0 0 .471-1.108z" />
                            </svg></span></a><a href="/options" class="desc"> Options</a>
                </li>
            </ul>
            <?php if (isset($_SESSION['user'])) { ?>
                <div class="side-bottom">
                    <button class="btn-posting">
                        <span class="mobile icon-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24">
                                <path d="M19.045 7.401c.378-.378.586-.88.586-1.414s-.208-1.036-.586-1.414l-1.586-1.586c-.378-.378-.88-.586-1.414-.586s-1.036.208-1.413.585L4 13.585V18h4.413L19.045 7.401zm-3-3 1.587 1.585-1.59 1.584-1.586-1.585 1.589-1.584zM6 16v-1.585l7.04-7.018 1.586 1.586L7.587 16H6zm-2 4h16v2H4z" />
                            </svg>
                        </span>
                        <span class="desktop">Posting</span>
                    </button>
                    <details class="details-up">
                        <summary>
                            <div class="profile">
                                <img src="img/uploads/<?= $data['pic'] ?>" alt="" />
                                <h4><?= $data['user'] ?></h4>
                            </div>
                        </summary>
                        <ul>
                            <li class="danger">
                                <a href="/logout" onclick="return confirm('Log out Now?')">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                            <path d="M16 13v-2H7V8l-5 4 5 4v-3z" />
                                            <path d="M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z" />
                                        </svg>
                                    </span>
                                    Logout</a>
                            </li>
                            <li>
                                <a href="/@<?= $_SESSION['user'] ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h17z" />
                                    </svg>
                                    Profile</a>
                            </li>
                        </ul>
                    </details>

                </div>
            <?php } ?>

        </div>
    </aside>

    <header>
        <div class="head-nav">
            <?php
            if ($data['title'] !== 'Home') {
            ?>

                <button onclick="back(1)">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24">
                        <path
                            d="M21 11H6.414l5.293-5.293-1.414-1.414L2.586 12l7.707 7.707 1.414-1.414L6.414 13H21z" />
                    </svg>
                </button>
            <?php } ?>
            <h1><?= $data['title'] ?></h1>
        </div>
        <div class="just-wrapper">
            <?php if (isset($_SESSION['user'])) { ?>
                <form action="/search" id="search" method="get">
                    <div class="form-wrapper">
                        <button type="submit">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24">
                                <path
                                    d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z" />
                            </svg>
                        </button>
                        <input type="text" name="q" id="search" placeholder="Search" value="<?= @$_GET['q'] ?>" />
                    </div>
                </form>
            <?php } else { ?>
                <a href="/login"><button class="btn">Login</button></a>
            <?php } ?>
        </div>

    </header>

    <div class="container">