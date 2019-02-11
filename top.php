<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>トップページ
    </title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>
<body>
<!--ヘッダー-->
<header class="header-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col header--container">
                <h1 class="header-top__title"><a href="top.php" class="header-top__link">MEMO!</a></h1>
                <nav class="nav-menu">
                    <ul class="c-menu">
                        <li class="c-menu__item"><a href="signup.php" class="c-menu__link">新規登録</a></li>
                        <li class="c-menu__item"><a href="login.php" class="c-menu__link">ログイン</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>
<!--メイン-->
<div class="slide-right">
    <section class="main" id="main">
        <div class="container-fluid section-top">
            <div class="row">
                <div class="col section-one">
                    <p class="section-one-h1">あなたの行動を<br/>
                        記録しよう!</p>
                    <p class="section-one-h2">どんなことでもいいです。<br/>
                        今日の天気はどうだったか<br/>
                        今日は何を食べたか<br/>
                        今日は何をしたか<br/>
                        書くことは自由です。</p>
                </div>
            </div>
        </div>
    </section>
</div>


<section class="bg-color-top bg-padding-bottom">
    <div class="container-fluid section-top">
        <div class="row">
            <div class="col section-two">
                <div class="slide-right">
                    <p class="section-two-h1">MEMO!とは？<br/></p>
                    <p class="section-two">あなただけの日記を書くことができます。<br/>
                        全世界にあなたの記録をみせよう。<br/>
                    </p>
                </div>
            </div>
        </div>

        <!--        フェードアウト用-->
        <div class="slide-top">


            <div class="row">
                <div class="col-lg-4 col-12">
                    <div class="c-panel">
                        <i class="fas fa-dollar-sign fa-2x u-color--font"></i>
                        <div class="c-panel__item c-panel__item--text">無料でできます！</div>
                    </div>
                </div>

                <div class="col-lg-4 col-12">
                    <div class="c-panel">
                        <i class="fas fa-address-book fa-2x u-color--font"></i>
                        <div class="c-panel__item c-panel__item--text">登録も簡単！</div>
                    </div>
                </div>

                <div class="col-lg-4 col-12">
                    <div class="c-panel">
                        <i class="far fa-laugh fa-2x u-color--font"></i>
                        <div class="c-panel__item c-panel__item--text">操作も簡単！</div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    </div>
</section>


<div class="slide-right">
    <section class="section-top">
        <div class="container">
            <div class="row">
                <div class="col section-three">
                    <h1 class="section-three--title">
                        <sapn>さあ、はじめよう！</sapn>
                    </h1>
                    <a class="c-button" href="signup.php">新規登録</a>
                </div>

            </div>
        </div>
    </section>
</div>


<footer class="footer-top">
    <span>Copyright  ©︎</span>
</footer>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>

<!--フェードイン用-->
<script src="node_modules/jquery-fadethis-master/libs/jquery/jquery.js"></script>
<script src="node_modules/jquery-fadethis-master/dist/jquery.fadethis.min.js"></script>

<script src="top.js"></script>
</body>
</html>