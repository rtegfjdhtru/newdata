<!--ログインしてない場合　ヘッダー非表示-->
<?php  if(!empty($_SESSION['user_id'])){ ?>
<div id="header" class="header bg-light u-header">
<div class="container-fluid">
    <div class="row">
        <div class="col-sm">


            <nav class="navbar navbar-expand-lg navbar-light">
                <h1 class="header-title"><a class="navbar-brand" href="index.php">MEMO!</a></h1>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">

                        <li class="nav-item active">
                            <a class="nav-link" href="contantspost.php">投稿 <span class="sr-only">(current)</span></a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                MENU
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="profile.php">プロフィール</a>
                                <a class="dropdown-item" href="password_change.php">パスワード変更</a>
                                <a class="dropdown-item" href="logout.php">ログアウト</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="withdraw.php">退会</a>
                            </div>
                        </li>

                    </ul>
<!--                  検索欄-->
                    <form class="form-inline my-2 my-lg-0" action="" method="get">
                        <input class="form-control mr-sm-2 js-search" type="search" name="c_text" placeholder="検索" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0 js-btn" type="submit">検索</button>
                    </form>
                </div>
            </nav>

        </div>
    </div>
</div>

</div>
<?php }  ?>