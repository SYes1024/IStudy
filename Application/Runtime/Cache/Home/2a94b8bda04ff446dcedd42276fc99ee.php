<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>111</title>

    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

    <!-- css start-->
    <link href="/IStudy/Public/css/bootstrap.css" rel="stylesheet" type='text/css' media="all" />
    <link href="/IStudy/Public/css/dashboard.css" rel="stylesheet">
    <link href="/IStudy/Public/css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link href="/IStudy/Public/css/popuo-box.css" rel="stylesheet" type="text/css" media="all" />
    <link href="/IStudy/Public/css/toastr.min.css" rel="stylesheet">
    <link href="/IStudy/Public/plugins/nice-validator/jquery.validator.css" rel="stylesheet">

    <!-- js start-->
    <script src="/IStudy/Public/js/jquery-2.1.4.js"></script>
    <script src="/IStudy/Public/js/bootstrap.min.js"></script>
    <script src="/IStudy/Public/js/responsiveslides.min.js"></script>
    <script src="/IStudy/Public/js/jquery.magnific-popup.js" type="text/javascript"></script>
    <script src="/IStudy/Public/js/toastr.min.js"></script>
    <script src="/IStudy/Public/plugins/nice-validator/jquery.validator.min.js?local=zh-CN"></script>
    <script>
        $(document).ready(function() {
            $('.popup-with-zoom-anim').magnificPopup({
                type: 'inline',
                fixedContentPos: false,
                fixedBgPos: true,
                overflowY: 'auto',
                closeBtnInside: true,
                preloader: false,
                midClick: true,
                removalDelay: 300,
                mainClass: 'my-mfp-zoom-in'
            });

        });
    </script>
    <style>
        .signup {
            float: none !important;
            margin: auto;
            border-left: none;
        }
        #next{
            margin: 0;
        }
        #small-dialog3, #small-dialog{
            text-align: left;
        }
        nav {
            font-size: 14px;
        }
    </style>
    <script>
        $(function () {
            //警告框设置
            toastr.options = {
                closeButton: false,//是否显示关闭按钮
                debug: false,//是否使用debug模式
                progressBar: true,//是否显示进度条
                positionClass: "toast-top-center",
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                timeOut: "2000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut"
            };
            $.validator.setTheme('bootstrap', {
                validClass: 'has-success',
                invalidClass: 'has-error',
                bindClassTo: '.form-group',
                formClass: 'n-default n-bootstrap',
                msgClass: 'n-right'
            });
            $.validator("#form1", {
                fields: {
                    username: {
                        rule: "required; length(6~);remote(get:/IStudy/index.php/Home/Login/usernameOk)",
                        msg: {
                            required: "请填写账号",
                            length:"至少填写6位账号",
                        },
                        tip: "用于登录的账号",
                        ok: "名字可以使用",
                        timely: 1,
                        target: "#usernameMsg",
                    },
                    password: {
                        rule: "密码:required; length(6~)",
                        msg: {
                            required: "请填写密码",
                            length:"至少填写6位数密码",
                        },
                        tip: "用于登录的密码",
                        ok: "",
                        timely: 3,
                        target: "#pwdMsg"
                    },
                    pwdAgain: {
                        rule:"required; match(password)",
                        msg: {
                            required: "请填写密码",
                            match:"两次密码不一致",
                        },
                        tip: "请确保两次密码一致",
                        ok: "",
                        timely: 3,
                        target: "#verMsg"
                    },
                    name: {
                        rule: "required",
                        msg: {
                            required: "请填写姓名",
                        },
                        tip: "填写真实姓名有助于朋友找到你",
                        ok: "",
                        timely: 1,
                        target: "#nameMsg"
                    },
                    email: {
                        rule: "required;email; remote(get:/IStudy/index.php/Home/Login/emailOk)",
                        msg: {
                            required: "请填写邮箱",
                        },
                        tip: "邮箱用于验证",
                        ok: "",
                        timely: 1,
                        target: "#emailMsg",
                    },
                    verCode: {
                        rule: "required;remote(get:/IStudy/index.php/Home/Login/verCodeOk)",
                        msg: {
                            required: "请填写验证码",
                        },
                        tip: "请查看邮箱中的验证码",
                        ok: "验证码一致",
                        timely: 1,
                        target: "#codeMsg"
                    },
                },
                messages: {
                    email: "请填写正确的邮箱",
                },
                valid: function(form){
                    // 表单验证通过，提交表单
                    $.ajax({
                        url: "/IStudy/index.php/Home/Login/addStu",
                        type: "POST",
                        async: true,
                        data: $("#form1").serialize(),
                        success: function (data) {
                            if (data['code'] == 1) {
                                toastr.success(data['msg'], 'OK');
                                setTimeout(function() {
                                    window.location.href = "/IStudy/index.php/Home";
                                }, 2000);
                            } else {
                                toastr.error(data['msg'], 'ERROR');
                            }
                        }
                    });
                }
            });

            $('#form2').validator({
                fields: {
                    username: {
                        rule: "required",
                        msg: {
                            required: "请填写账号",
                        },
                        tip: "用于登录的账号",
                        ok: "",
                        timely: 1,
                        target: "#usernameMsg1",
                    },
                    password: {
                        rule: "密码:required;",
                        msg: {
                            required: "请填写密码",
                        },
                        tip: "用于登录的密码",
                        ok: "",
                        timely: 1,
                        target: "#pwdMsg1"
                    },
                },
                valid: function(form) {
                    $.ajax({
                        url: "/IStudy/index.php/Home/Login/login",
                        type: "POST",
                        async: true,
                        data: $("#form2").serialize(),
                        success: function (data) {
                            if (data['code'] == 1) {
                                toastr.success(data['msg'], 'OK');
                                setTimeout(function () {
                                    window.location.href = "/IStudy/index.php/Home";
                                }, 2000);
                            } else {
                                toastr.error(data['msg'], 'ERROR');
                            }
                        }
                    });
                }
            });
//            $.validator("#form2", {
//                fields: {
//                    username: {
//                        rule: "required",
//                        msg: {
//                            required: "请填写账号",
//                        },
//                        tip: "用于登录的账号",
//                        ok: "",
//                        timely: 1,
//                        target: "#usernameMsg1",
//                    },
//                    password: {
//                        rule: "密码:required;",
//                        msg: {
//                            required: "请填写密码",
//                        },
//                        tip: "用于登录的密码",
//                        ok: "",
//                        timely: 1,
//                        target: "#pwdMsg1"
//                    },
//                    valid: function(form) {
//                        // 表单验证通过，提交表单
//
//                    }
//                }
//            });
            /**
             * 邮箱验证下一步
             */
            $("#next").click(function(){
                $.ajax({
                    url:"/IStudy/index.php/Home/Login/sendVerCode?email="+$("#email").val(),
                    type:"GET",
                    success:function(data) {
                        if(data['code'] == 1){
                            toastr.success(data['msg'], 'OK');
                        }else{
                            toastr.error(data['msg'], 'ERROR');
                        }
                    }
                });
            });

            $("#loginOut").click(function () {
                $.ajax({
                    url: "/IStudy/index.php/Home/Login/loginOut",
                    type: "get",
                    success: function (data) {
                        if (data['code'] == 1) {
                            toastr.success(data['msg'], 'OK');
                            setTimeout(function() {
                                window.location.href = "/IStudy/index.php/Home";
                            }, 2000);
                        } else {
                            toastr.error(data['msg'], 'ERROR');
                        }
                    }
                });
            });

        });
    </script>
    
</head>
<body>
<!-- nav start -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html"><h1>
                <img src="/IStudy/Public/images/logo.png" alt="" /></h1></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <div class="top-search">
                <form class="navbar-form navbar-right">
                    <input type="text" class="form-control" placeholder="Search...">
                    <input type="submit" value=" ">
                </form>
            </div>
            <div class="header-top-right">
                <?php if(empty($_SESSION['username'])): ?><!--<div class="file">-->
                        <!--<a href="upload.html">Upload</a>-->
                    <!--</div>-->
                    <div class="signin">
                        <a href="#small-dialog3" class="play-icon popup-with-zoom-anim">注册</a>
                    </div>
                    <!-- 登录按钮-->
                    <div class="signin">
                        <a href="#small-dialog" class="play-icon popup-with-zoom-anim">登录</a>
                    </div>
                <?php else: ?>
                    欢迎,<?php echo (session('name')); ?>,<button id="loginOut">退出</button><?php endif; ?>

                <!-- 登录框-->
                <div id="small-dialog" class="mfp-hide">
                    <h3>登录</h3>
                    <div class="col-sm-12 col-md-6 col-md-offset-3 login1">
                        <form id="form2" data-validator-option="{theme:'bootstrap', timely:2, stopOnError:true}">
                            <div class="form-group">
                                <label class="control-label">账号</label>
                                <input type="text" class="form-control" name="username">
                                <span class="msg-box" id="usernameMsg1"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">密码</label>
                                <input type="password" class="form-control" name="password">
                                <span class="msg-box" id="pwdMsg1"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">登录</button>
                                <button type="reset" class="btn btn-default">重置</button>
                            </div>
                        </form>
                        <div class="button-bottom">
                            <p>没有账号? <a href="#small-dialog3" class="play-icon popup-with-zoom-anim">点击注册</a></p>
                        </div>
                        <div class="forgot">
                            <a href="#">忘记密码?</a>
                        </div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
                <!-- 注册框 -->
                <div id="small-dialog3" class="mfp-hide">
                    <h3>注册账号</h3>
                    <div class="col-sm-12 col-md-6 col-md-offset-3 login1">
                        <form id="form1" data-validator-option="{theme:'bootstrap', timely:2, stopOnError:true}">
                            <div class="form-group">
                                <label class="control-label">账号</label>
                                <input type="text" class="form-control" name="username">
                                <span class="msg-box" id="usernameMsg"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">密码</label>
                                <input type="password" class="form-control" name="password">
                                <span class="msg-box" id="pwdMsg"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">确认密码</label>
                                <input type="password" class="form-control" name="pwdAgain">
                                <span class="msg-box" id="verMsg"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">姓名</label>
                                <input type="text" class="form-control" name="name">
                                <span class="msg-box" id="nameMsg"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Email</label>
                                <input type="text" class="form-control" name="email" id="email">
                                <button type="button" id="next">获取验证码</button>
                                <span class="msg-box" id="emailMsg"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">验证码</label>
                                <input type="text" class="form-control" name="verCode">
                                <span class="msg-box" id="codeMsg"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">注册</button>
                                <button type="reset" class="btn btn-default">重置</button>
                            </div>
                        </form>
                        <div class="button-bottom">
                            <p>已经有账号了? <a href="#small-dialog" class="play-icon popup-with-zoom-anim">登录</a>
                            </p>
                        </div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
                <div id="small-dialog7" class="mfp-hide">
                    <h3>Create Account</h3>
                    <div class="social-sits">
                        <div class="facebook-button">
                            <a href="#">Connect with Facebook</a>
                        </div>
                        <div class="chrome-button">
                            <a href="#">Connect with Google</a>
                        </div>
                        <div class="button-bottom">
                            <p>Already have an account? <a href="#small-dialog" class="play-icon popup-with-zoom-anim">Login</a></p>
                        </div>
                    </div>
                    <div class="signup">
                        <!--<form action="upload.html">-->
                            <!--<input type="text" class="email" placeholder="Email" required="required" pattern="([\w-\.]+@([\w-]+\.)+[\w-]{2,4})" title="Enter a valid email"/>-->
                            <!--<input type="password" placeholder="Password" required="required" pattern=".{6,}" title="Minimum 6 characters required" autocomplete="off" />-->
                            <!--<input type="submit"  value="Sign In"/>-->
                        <!--</form>-->
                    </div>
                    <div class="clearfix"> </div>
                </div>
                <div id="small-dialog4" class="mfp-hide">
                    <h3>Feedback</h3>
                    <div class="feedback-grids">
                        <div class="feedback-grid">
                            <p>Suspendisse tristique magna ut urna pellentesque, ut egestas velit faucibus. Nullam mattis lectus ullamcorper dui dignissim, sit amet egestas orci ullamcorper.</p>
                        </div>
                        <div class="button-bottom">
                            <p><a href="#small-dialog" class="play-icon popup-with-zoom-anim">Sign in</a> to get started.</p>
                        </div>
                    </div>
                </div>
                <div id="small-dialog5" class="mfp-hide">
                    <h3>Help</h3>
                    <div class="help-grid">
                        <p>Suspendisse tristique magna ut urna pellentesque, ut egestas velit faucibus. Nullam mattis lectus ullamcorper dui dignissim, sit amet egestas orci ullamcorper.</p>
                    </div>
                    <div class="help-grids">
                        <div class="help-button-bottom">
                            <p><a href="#small-dialog4" class="play-icon popup-with-zoom-anim">Feedback</a></p>
                        </div>
                        <div class="help-button-bottom">
                            <p><a href="#small-dialog6" class="play-icon popup-with-zoom-anim">Lorem ipsum dolor sit amet</a></p>
                        </div>
                        <div class="help-button-bottom">
                            <p><a href="#small-dialog6" class="play-icon popup-with-zoom-anim">Nunc vitae rutrum enim</a></p>
                        </div>
                        <div class="help-button-bottom">
                            <p><a href="#small-dialog6" class="play-icon popup-with-zoom-anim">Mauris at volutpat leo</a></p>
                        </div>
                        <div class="help-button-bottom">
                            <p><a href="#small-dialog6" class="play-icon popup-with-zoom-anim">Mauris vehicula rutrum velit</a></p>
                        </div>
                        <div class="help-button-bottom">
                            <p><a href="#small-dialog6" class="play-icon popup-with-zoom-anim">Aliquam eget ante non orci fac</a></p>
                        </div>
                    </div>
                </div>
                <div id="small-dialog6" class="mfp-hide">
                    <div class="video-information-text">
                        <h4>Video information & settings</h4>
                        <p>Suspendisse tristique magna ut urna pellentesque, ut egestas velit faucibus. Nullam mattis lectus ullamcorper dui dignissim, sit amet egestas orci ullamcorper.</p>
                        <ol>
                            <li>Nunc vitae rutrum enim. Mauris at volutpat leo. Vivamus dapibus mi ut elit fermentum tincidunt.</li>
                            <li>Nunc vitae rutrum enim. Mauris at volutpat leo. Vivamus dapibus mi ut elit fermentum tincidunt.</li>
                            <li>Nunc vitae rutrum enim. Mauris at volutpat leo. Vivamus dapibus mi ut elit fermentum tincidunt.</li>
                            <li>Nunc vitae rutrum enim. Mauris at volutpat leo. Vivamus dapibus mi ut elit fermentum tincidunt.</li>
                            <li>Nunc vitae rutrum enim. Mauris at volutpat leo. Vivamus dapibus mi ut elit fermentum tincidunt.</li>
                        </ol>
                    </div>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
        <div class="clearfix"> </div>
    </div>
</nav>
<!-- nav end -->

<!-- sidebar start-->
<div class="col-sm-3 col-md-2 sidebar">
    <div class="top-navigation">
        <div class="t-menu">MENU</div>
        <div class="t-img">
            <img src="/IStudy/Public/images/lines.png" alt="" />
        </div>
        <div class="clearfix"> </div>
    </div><!--  移动端显示-->
    <div class="drop-navigation drop-navigation">
        <ul class="nav nav-sidebar">
            <li class="active"><a href="index.html" class="home-icon"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>主页</a></li>
            <li><a href="shows.html" class="user-icon"><span class="glyphicon glyphicon-home glyphicon-blackboard" aria-hidden="true"></span>我的课程</a></li>
            <?php if(($_SESSION['category']) == "2"): ?><li><a href="#" class="menu1"><span class="glyphicon glyphicon-film" aria-hidden="true"></span>课程管理<span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></a></li>
            <ul class="cl-effect-2">
                <li><a href="/IStudy/index.php/Home/Index/newCourse">开设新课程</a></li>
                <li><a href="movies.html">管理已有课程</a></li>
            </ul><?php endif; ?>
            <!-- script-for-menu -->
            <script>
                $( "li a.menu1" ).click(function() {
                    $( "ul.cl-effect-2" ).slideToggle( 300, function() {
                        // Animation complete.
                    });
                });
            </script>
            <li><a href="#" class="menu"><span class="glyphicon glyphicon-film glyphicon-king" aria-hidden="true"></span>Sports<span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></a></li>
            <ul class="cl-effect-1">
                <li><a href="sports.html">Football</a></li>
                <li><a href="sports.html">Cricket</a></li>
                <li><a href="sports.html">Tennis</a></li>
                <li><a href="sports.html">Shattil</a></li>
            </ul>
            <!-- script-for-menu -->
            <script>
                $( "li a.menu" ).click(function() {
                    $( "ul.cl-effect-1" ).slideToggle( 300, function() {
                        // Animation complete.
                    });
                });
            </script>
            <li><a href="movies.html" class="song-icon"><span class="glyphicon glyphicon-music" aria-hidden="true"></span>Songs</a></li>
            <li><a href="news.html" class="news-icon"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>News</a></li>
        </ul>
        <!-- script-for-menu -->
        <script>
            $( ".top-navigation" ).click(function() {
                $( ".drop-navigation" ).slideToggle( 300, function() {
                    // Animation complete.
                });
            });
        </script>
        <!--<div class="side-bottom">
            <div class="side-bottom-icons">
                <ul class="nav2">
                    <li><a href="#" class="facebook"> </a></li>
                    <li><a href="#" class="facebook twitter"> </a></li>
                    <li><a href="#" class="facebook chrome"> </a></li>
                    <li><a href="#" class="facebook dribbble"> </a></li>
                </ul>
            </div>
        </div>-->
    </div>
</div>
<!-- sidebar end-->

<!-- main start-->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div class="main-grids">
    
            <div class="top-grids">
                <div class="recommended-info">
                    <h3>最新视频</h3>
                </div>
                <div class="col-md-4 resent-grid recommended-grid slider-top-grids">
                    <div class="resent-grid-img recommended-grid-img">
                        <a href="single.html"><img src="/IStudy/Public/images/t1.jpg" alt="" /></a>
                        <div class="time">
                            <p>3:04</p>
                        </div>
                        <div class="clck">
                            <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="resent-grid-info recommended-grid-info">
                        <h3><a href="single.html" class="title title-info">Pellentesque vitae pulvinar tortor nullam interdum metus a imperdiet</a></h3>
                        <ul>
                            <li><p class="author author-info"><a href="#" class="author">John Maniya</a></p></li>
                            <li class="right-list"><p class="views views-info">2,114,200 views</p></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 resent-grid recommended-grid slider-top-grids">
                    <div class="resent-grid-img recommended-grid-img">
                        <a href="single.html"><img src="/IStudy/Public/images/t2.jpg" alt="" /></a>
                        <div class="time">
                            <p>7:23</p>
                        </div>
                        <div class="clck">
                            <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="resent-grid-info recommended-grid-info">
                        <h3><a href="single.html" class="title title-info">Interdum pellentesque vitae pulvinar tortor nullam metus a imperdiet</a></h3>
                        <ul>
                            <li><p class="author author-info"><a href="#" class="author">John Maniya</a></p></li>
                            <li class="right-list"><p class="views views-info">4,200 views</p></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 resent-grid recommended-grid slider-top-grids">
                    <div class="resent-grid-img recommended-grid-img">
                        <a href="single.html"><img src="/IStudy/Public/images/t3.jpg" alt="" /></a>
                        <div class="time">
                            <p>4:04</p>
                        </div>
                        <div class="clck">
                            <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="resent-grid-info recommended-grid-info">
                        <h3><a href="single.html" class="title title-info">Nullam interdum metus a imperdiet pellentesque vitae pulvinar tortor</a></h3>
                        <ul>
                            <li><p class="author author-info"><a href="#" class="author">John Maniya</a></p></li>
                            <li class="right-list"><p class="views views-info">71,174 views</p></li>
                        </ul>
                    </div>
                </div>
                <div class="clearfix"> </div>
            </div>
            <div class="recommended">
                <div class="recommended-grids">
                    <div class="recommended-info">
                        <h3>最热视频</h3>
                    </div>
                    <script src="/IStudy/Public/js/responsiveslides.min.js"></script>
                    <script>
                        // You can also use "$(window).load(function() {"
                        $(function () {
                            // Slideshow 4
                            $("#slider3").responsiveSlides({
                                auto: true,
                                pager: false,
                                nav: true,
                                speed: 500,
                                namespace: "callbacks",
                                before: function () {
                                    $('.events').append("<li>before event fired.</li>");
                                },
                                after: function () {
                                    $('.events').append("<li>after event fired.</li>");
                                }
                            });

                        });
                    </script>
                    <div  id="top" class="callbacks_container">
                        <ul class="rslides" id="slider3">
                            <li>
                                <div class="animated-grids">
                                    <div class="col-md-3 resent-grid recommended-grid slider-first">
                                        <div class="resent-grid-img recommended-grid-img">
                                            <a href="single.html"><img src="/IStudy/Public/images/c.jpg" alt="" /></a>
                                            <div class="time small-time slider-time">
                                                <p>7:34</p>
                                            </div>
                                            <div class="clck small-clck">
                                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="resent-grid-info recommended-grid-info">
                                            <h5><a href="single.html" class="title">Varius sit sed viverra nullam viverra nullam interdum metus</a></h5>
                                            <div class="slid-bottom-grids">
                                                <div class="slid-bottom-grid">
                                                    <p class="author author-info"><a href="#" class="author">John Maniya</a></p>
                                                </div>
                                                <div class="slid-bottom-grid slid-bottom-right">
                                                    <p class="views views-info">2,114,200 views</p>
                                                </div>
                                                <div class="clearfix"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 resent-grid recommended-grid slider-first">
                                        <div class="resent-grid-img recommended-grid-img">
                                            <a href="single.html"><img src="/IStudy/Public/images/c1.jpg" alt="" /></a>
                                            <div class="time small-time slider-time">
                                                <p>6:23</p>
                                            </div>
                                            <div class="clck small-clck">
                                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="resent-grid-info recommended-grid-info">
                                            <h5><a href="single.html" class="title">Nullam interdum metus varius viverra nullam sit amet viverra</a></h5>
                                            <div class="slid-bottom-grids">
                                                <div class="slid-bottom-grid">
                                                    <p class="author author-info"><a href="#" class="author">John Maniya</a></p>
                                                </div>
                                                <div class="slid-bottom-grid slid-bottom-right">
                                                    <p class="views views-info">14,200 views</p>
                                                </div>
                                                <div class="clearfix"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 resent-grid recommended-grid slider-first">
                                        <div class="resent-grid-img recommended-grid-img">
                                            <a href="single.html"><img src="/IStudy/Public/images/c2.jpg" alt="" /></a>
                                            <div class="time small-time slider-time">
                                                <p>2:45</p>
                                            </div>
                                            <div class="clck small-clck">
                                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="resent-grid-info recommended-grid-info">
                                            <h5><a href="single.html" class="title">Varius sit sed viverra nullam viverra nullam interdum metus</a></h5>
                                            <div class="slid-bottom-grids">
                                                <div class="slid-bottom-grid">
                                                    <p class="author author-info"><a href="#" class="author">John Maniya</a></p>
                                                </div>
                                                <div class="slid-bottom-grid slid-bottom-right">
                                                    <p class="views views-info">2,114,200 views</p>
                                                </div>
                                                <div class="clearfix"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 resent-grid recommended-grid slider-first">
                                        <div class="resent-grid-img recommended-grid-img">
                                            <a href="single.html"><img src="/IStudy/Public/images/c3.jpg" alt="" /></a>
                                            <div class="time small-time slider-time">
                                                <p>4:34</p>
                                            </div>
                                            <div class="clck small-clck">
                                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="resent-grid-info recommended-grid-info">
                                            <h5><a href="single.html" class="title">Nullam interdum metus viverra nullam varius sit sed viverra</a></h5>
                                            <div class="slid-bottom-grids">
                                                <div class="slid-bottom-grid">
                                                    <p class="author author-info"><a href="#" class="author">John Maniya</a></p>
                                                </div>
                                                <div class="slid-bottom-grid slid-bottom-right">
                                                    <p class="views views-info">2,114,200 views</p>
                                                </div>
                                                <div class="clearfix"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"> </div>
                                </div>
                            </li>
                            <li>
                                <div class="animated-grids">
                                    <div class="col-md-3 resent-grid recommended-grid slider-first">
                                        <div class="resent-grid-img recommended-grid-img">
                                            <a href="single.html"><img src="/IStudy/Public/images/c1.jpg" alt="" /></a>
                                            <div class="time small-time slider-time">
                                                <p>4:42</p>
                                            </div>
                                            <div class="clck small-clck">
                                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="resent-grid-info recommended-grid-info">
                                            <h5><a href="single.html" class="title">Varius sit sed viverra viverra nullam nullam interdum metus</a></h5>
                                            <div class="slid-bottom-grids">
                                                <div class="slid-bottom-grid">
                                                    <p class="author author-info"><a href="#" class="author">John Maniya</a></p>
                                                </div>
                                                <div class="slid-bottom-grid slid-bottom-right">
                                                    <p class="views views-info">2,114,200 views</p>
                                                </div>
                                                <div class="clearfix"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 resent-grid recommended-grid slider-first">
                                        <div class="resent-grid-img recommended-grid-img">
                                            <a href="single.html"><img src="/IStudy/Public/images/c2.jpg" alt="" /></a>
                                            <div class="time small-time slider-time">
                                                <p>6:14</p>
                                            </div>
                                            <div class="clck small-clck">
                                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="resent-grid-info recommended-grid-info">
                                            <h5><a href="single.html" class="title">Nullam interdum metus viverra nullam varius sit sed viverra</a></h5>
                                            <div class="slid-bottom-grids">
                                                <div class="slid-bottom-grid">
                                                    <p class="author author-info"><a href="#" class="author">John Maniya</a></p>
                                                </div>
                                                <div class="slid-bottom-grid slid-bottom-right">
                                                    <p class="views views-info">2,114,200 views</p>
                                                </div>
                                                <div class="clearfix"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 resent-grid recommended-grid slider-first">
                                        <div class="resent-grid-img recommended-grid-img">
                                            <a href="single.html"><img src="/IStudy/Public/images/c3.jpg" alt="" /></a>
                                            <div class="time small-time slider-time">
                                                <p>2:34</p>
                                            </div>
                                            <div class="clck small-clck">
                                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="resent-grid-info recommended-grid-info">
                                            <h5><a href="single.html" class="title">varius sit sed viverra viverra nullam Nullam interdum metus</a></h5>
                                            <div class="slid-bottom-grids">
                                                <div class="slid-bottom-grid">
                                                    <p class="author author-info"><a href="#" class="author">John Maniya</a></p>
                                                </div>
                                                <div class="slid-bottom-grid slid-bottom-right">
                                                    <p class="views views-info">2,114,200 views</p>
                                                </div>
                                                <div class="clearfix"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 resent-grid recommended-grid slider-first">
                                        <div class="resent-grid-img recommended-grid-img">
                                            <a href="single.html"><img src="/IStudy/Public/images/c.jpg" alt="" /></a>
                                            <div class="time small-time slider-time">
                                                <p>5:12</p>
                                            </div>
                                            <div class="clck small-clck">
                                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="resent-grid-info recommended-grid-info">
                                            <h5><a href="single.html" class="title">Nullam interdum metus viverra nullam varius sit sed viverra</a></h5>
                                            <div class="slid-bottom-grids">
                                                <div class="slid-bottom-grid">
                                                    <p class="author author-info"><a href="#" class="author">John Maniya</a></p>
                                                </div>
                                                <div class="slid-bottom-grid slid-bottom-right">
                                                    <p class="views views-info">1,14,200 views</p>
                                                </div>
                                                <div class="clearfix"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"> </div>
                                </div>
                            </li>
                            <li>
                                <div class="animated-grids">
                                    <div class="col-md-3 resent-grid recommended-grid slider-first">
                                        <div class="resent-grid-img recommended-grid-img">
                                            <a href="single.html"><img src="/IStudy/Public/images/c2.jpg" alt="" /></a>
                                            <div class="time small-time slider-time">
                                                <p>4:42</p>
                                            </div>
                                            <div class="clck small-clck">
                                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="resent-grid-info recommended-grid-info">
                                            <h5><a href="single.html" class="title">Varius sit sed viverra viverra nullam nullam interdum metus</a></h5>
                                            <div class="slid-bottom-grids">
                                                <div class="slid-bottom-grid">
                                                    <p class="author author-info"><a href="#" class="author">John Maniya</a></p>
                                                </div>
                                                <div class="slid-bottom-grid slid-bottom-right">
                                                    <p class="views views-info">2,114,200 views</p>
                                                </div>
                                                <div class="clearfix"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 resent-grid recommended-grid slider-first">
                                        <div class="resent-grid-img recommended-grid-img">
                                            <a href="single.html"><img src="/IStudy/Public/images/c3.jpg" alt="" /></a>
                                            <div class="time small-time slider-time">
                                                <p>6:14</p>
                                            </div>
                                            <div class="clck small-clck">
                                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="resent-grid-info recommended-grid-info">
                                            <h5><a href="single.html" class="title">Nullam interdum metus viverra nullam varius sit sed viverra</a></h5>
                                            <div class="slid-bottom-grids">
                                                <div class="slid-bottom-grid">
                                                    <p class="author author-info"><a href="#" class="author">John Maniya</a></p>
                                                </div>
                                                <div class="slid-bottom-grid slid-bottom-right">
                                                    <p class="views views-info">2,114,200 views</p>
                                                </div>
                                                <div class="clearfix"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 resent-grid recommended-grid slider-first">
                                        <div class="resent-grid-img recommended-grid-img">
                                            <a href="single.html"><img src="/IStudy/Public/images/c.jpg" alt="" /></a>
                                            <div class="time small-time slider-time">
                                                <p>2:34</p>
                                            </div>
                                            <div class="clck small-clck">
                                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="resent-grid-info recommended-grid-info">
                                            <h5><a href="single.html" class="title">varius sit sed viverra viverra nullam Nullam interdum metus</a></h5>
                                            <div class="slid-bottom-grids">
                                                <div class="slid-bottom-grid">
                                                    <p class="author author-info"><a href="#" class="author">John Maniya</a></p>
                                                </div>
                                                <div class="slid-bottom-grid slid-bottom-right">
                                                    <p class="views views-info">2,114,200 views</p>
                                                </div>
                                                <div class="clearfix"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 resent-grid recommended-grid slider-first">
                                        <div class="resent-grid-img recommended-grid-img">
                                            <a href="single.html"><img src="/IStudy/Public/images/c3.jpg" alt="" /></a>
                                            <div class="time small-time slider-time">
                                                <p>5:12</p>
                                            </div>
                                            <div class="clck small-clck">
                                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="resent-grid-info recommended-grid-info">
                                            <h5><a href="single.html" class="title">Nullam interdum metus viverra nullam varius sit sed viverra</a></h5>
                                            <div class="slid-bottom-grids">
                                                <div class="slid-bottom-grid">
                                                    <p class="author author-info"><a href="#" class="author">John Maniya</a></p>
                                                </div>
                                                <div class="slid-bottom-grid slid-bottom-right">
                                                    <p class="views views-info">1,14,200 views</p>
                                                </div>
                                                <div class="clearfix"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"> </div>
                                </div>
                            </li>
                            <li>
                                <div class="animated-grids">
                                    <div class="col-md-3 resent-grid recommended-grid slider-first">
                                        <div class="resent-grid-img recommended-grid-img">
                                            <a href="single.html"><img src="/IStudy/Public/images/c3.jpg" alt="" /></a>
                                            <div class="time small-time slider-time">
                                                <p>4:42</p>
                                            </div>
                                            <div class="clck small-clck">
                                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="resent-grid-info recommended-grid-info">
                                            <h5><a href="single.html" class="title">Varius sit sed viverra viverra nullam nullam interdum metus</a></h5>
                                            <div class="slid-bottom-grids">
                                                <div class="slid-bottom-grid">
                                                    <p class="author author-info"><a href="#" class="author">John Maniya</a></p>
                                                </div>
                                                <div class="slid-bottom-grid slid-bottom-right">
                                                    <p class="views views-info">2,114,200 views</p>
                                                </div>
                                                <div class="clearfix"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 resent-grid recommended-grid slider-first">
                                        <div class="resent-grid-img recommended-grid-img">
                                            <a href="single.html"><img src="/IStudy/Public/images/c.jpg" alt="" /></a>
                                            <div class="time small-time slider-time">
                                                <p>6:14</p>
                                            </div>
                                            <div class="clck small-clck">
                                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="resent-grid-info recommended-grid-info">
                                            <h5><a href="single.html" class="title">Nullam interdum metus viverra nullam varius sit sed viverra</a></h5>
                                            <div class="slid-bottom-grids">
                                                <div class="slid-bottom-grid">
                                                    <p class="author author-info"><a href="#" class="author">John Maniya</a></p>
                                                </div>
                                                <div class="slid-bottom-grid slid-bottom-right">
                                                    <p class="views views-info">2,114,200 views</p>
                                                </div>
                                                <div class="clearfix"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 resent-grid recommended-grid slider-first">
                                        <div class="resent-grid-img recommended-grid-img">
                                            <a href="single.html"><img src="/IStudy/Public/images/c1.jpg" alt="" /></a>
                                            <div class="time small-time slider-time">
                                                <p>2:34</p>
                                            </div>
                                            <div class="clck small-clck">
                                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="resent-grid-info recommended-grid-info">
                                            <h5><a href="single.html" class="title">varius sit sed viverra viverra nullam Nullam interdum metus</a></h5>
                                            <div class="slid-bottom-grids">
                                                <div class="slid-bottom-grid">
                                                    <p class="author author-info"><a href="#" class="author">John Maniya</a></p>
                                                </div>
                                                <div class="slid-bottom-grid slid-bottom-right">
                                                    <p class="views views-info">2,114,200 views</p>
                                                </div>
                                                <div class="clearfix"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 resent-grid recommended-grid slider-first">
                                        <div class="resent-grid-img recommended-grid-img">
                                            <a href="single.html"><img src="/IStudy/Public/images/c2.jpg" alt="" /></a>
                                            <div class="time small-time slider-time">
                                                <p>5:12</p>
                                            </div>
                                            <div class="clck small-clck">
                                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="resent-grid-info recommended-grid-info">
                                            <h5><a href="single.html" class="title">Nullam interdum metus viverra nullam varius sit sed viverra</a></h5>
                                            <div class="slid-bottom-grids">
                                                <div class="slid-bottom-grid">
                                                    <p class="author author-info"><a href="#" class="author">John Maniya</a></p>
                                                </div>
                                                <div class="slid-bottom-grid slid-bottom-right">
                                                    <p class="views views-info">1,14,200 views</p>
                                                </div>
                                                <div class="clearfix"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"> </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="recommended">
                <div class="recommended-grids">
                    <div class="recommended-info">
                        <h3>Recommended</h3>
                    </div>
                    <div class="col-md-3 resent-grid recommended-grid">
                        <div class="resent-grid-img recommended-grid-img">
                            <a href="single.html"><img src="/IStudy/Public/images/r1.jpg" alt="" /></a>
                            <div class="time small-time">
                                <p>2:34</p>
                            </div>
                            <div class="clck small-clck">
                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="resent-grid-info recommended-grid-info video-info-grid">
                            <h5><a href="single.html" class="title">Varius sit sed viverra viverra nullam nullam interdum metus</a></h5>
                            <ul>
                                <li><p class="author author-info"><a href="#" class="author">John Maniya</a></p></li>
                                <li class="right-list"><p class="views views-info">2,114,200 views</p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 resent-grid recommended-grid">
                        <div class="resent-grid-img recommended-grid-img">
                            <a href="single.html"><img src="/IStudy/Public/images/r2.jpg" alt="" /></a>
                            <div class="time small-time">
                                <p>3:02</p>
                            </div>
                            <div class="clck small-clck">
                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="resent-grid-info recommended-grid-info video-info-grid">
                            <h5><a href="single.html" class="title">Nullam interdum metus viverra nullam varius sit sed viverra</a></h5>
                            <ul>
                                <li><p class="author author-info"><a href="#" class="author">John Maniya</a></p></li>
                                <li class="right-list"><p class="views views-info">2,114,200 views</p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 resent-grid recommended-grid">
                        <div class="resent-grid-img recommended-grid-img">
                            <a href="single.html"><img src="/IStudy/Public/images/r3.jpg" alt="" /></a>
                            <div class="time small-time">
                                <p>1:34</p>
                            </div>
                            <div class="clck small-clck">
                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="resent-grid-info recommended-grid-info video-info-grid">
                            <h5><a href="single.html" class="title">Varius sit sed viverra nullam viverra nullam interdum metus</a></h5>
                            <ul>
                                <li><p class="author author-info"><a href="#" class="author">John Maniya</a></p></li>
                                <li class="right-list"><p class="views views-info">2,114,200 views</p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 resent-grid recommended-grid">
                        <div class="resent-grid-img recommended-grid-img">
                            <a href="single.html"><img src="/IStudy/Public/images/r4.jpg" alt="" /></a>
                            <div class="time small-time">
                                <p>2:09</p>
                            </div>
                            <div class="clck small-clck">
                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="resent-grid-info recommended-grid-info video-info-grid">
                            <h5><a href="single.html" class="title">Nullam interdum viverra nullam metus varius sit sed viverra</a></h5>
                            <ul>
                                <li><p class="author author-info"><a href="#" class="author">John Maniya</a></p></li>
                                <li class="right-list"><p class="views views-info">2,114,200 views</p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
                <div class="recommended-grids">
                    <div class="col-md-3 resent-grid recommended-grid">
                        <div class="resent-grid-img recommended-grid-img">
                            <a href="single.html"><img src="/IStudy/Public/images/r4.jpg" alt="" /></a>
                            <div class="time small-time">
                                <p>6:34</p>
                            </div>
                            <div class="clck small-clck">
                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="resent-grid-info recommended-grid-info video-info-grid">
                            <h5><a href="single.html" class="title">Varius sit sed viverra nullam viverra nullam interdum metus</a></h5>
                            <ul>
                                <li><p class="author author-info"><a href="#" class="author">John Maniya</a></p></li>
                                <li class="right-list"><p class="views views-info">2,114,200 views</p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 resent-grid recommended-grid">
                        <div class="resent-grid-img recommended-grid-img">
                            <a href="single.html"><img src="/IStudy/Public/images/r5.jpg" alt="" /></a>
                            <div class="time small-time">
                                <p>7:34</p>
                            </div>
                            <div class="clck small-clck">
                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="resent-grid-info recommended-grid-info video-info-grid">
                            <h5><a href="single.html" class="title">Nullam interdum metus viverra nullam varius sit sed viverra</a></h5>
                            <ul>
                                <li><p class="author author-info"><a href="#" class="author">John Maniya</a></p></li>
                                <li class="right-list"><p class="views views-info">2,114,200 views</p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 resent-grid recommended-grid">
                        <div class="resent-grid-img recommended-grid-img">
                            <a href="single.html"><img src="/IStudy/Public/images/r6.jpg" alt="" /></a>
                            <div class="time small-time">
                                <p>6:09</p>
                            </div>
                            <div class="clck small-clck">
                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="resent-grid-info recommended-grid-info video-info-grid">
                            <h5><a href="single.html" class="title">Varius sit sed viverra nullam viverra nullam interdum metus</a></h5>
                            <ul>
                                <li><p class="author author-info"><a href="#" class="author">John Maniya</a></p></li>
                                <li class="right-list"><p class="views views-info">2,114,200 views</p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 resent-grid recommended-grid">
                        <div class="resent-grid-img recommended-grid-img">
                            <a href="single.html"><img src="/IStudy/Public/images/r1.jpg" alt="" /></a>
                            <div class="time small-time">
                                <p>9:04</p>
                            </div>
                            <div class="clck small-clck">
                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="resent-grid-info recommended-grid-info video-info-grid">
                            <h5><a href="single.html" class="title">Nullam interdum metus viverra nullam varius sit sed viverra</a></h5>
                            <ul>
                                <li><p class="author author-info"><a href="#" class="author">John Maniya</a></p></li>
                                <li class="right-list"><p class="views views-info">2,114,200 views</p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
            <div class="recommended">
                <div class="recommended-grids">
                    <div class="recommended-info">
                        <h3>Sports</h3>
                    </div>
                    <div class="col-md-3 resent-grid recommended-grid">
                        <div class="resent-grid-img recommended-grid-img">
                            <a href="single.html"><img src="/IStudy/Public/images/g.jpg" alt="" /></a>
                            <div class="time small-time">
                                <p>7:30</p>
                            </div>
                            <div class="clck small-clck">
                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="resent-grid-info recommended-grid-info video-info-grid">
                            <h5><a href="single.html" class="title">Varius sit sed viverra nullam viverra nullam interdum metus</a></h5>
                            <ul>
                                <li><p class="author author-info"><a href="#" class="author">John Maniya</a></p></li>
                                <li class="right-list"><p class="views views-info">2,114,200 views</p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 resent-grid recommended-grid">
                        <div class="resent-grid-img recommended-grid-img">
                            <a href="single.html"><img src="/IStudy/Public/images/g1.jpg" alt="" /></a>
                            <div class="time small-time">
                                <p>9:34</p>
                            </div>
                            <div class="clck small-clck">
                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="resent-grid-info recommended-grid-info video-info-grid">
                            <h5><a href="single.html" class="title">Nullam interdum viverra nullam metus varius sit sed viverra</a></h5>
                            <ul>
                                <li><p class="author author-info"><a href="#" class="author">John Maniya</a></p></li>
                                <li class="right-list"><p class="views views-info">2,114,200 views</p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 resent-grid recommended-grid">
                        <div class="resent-grid-img recommended-grid-img">
                            <a href="single.html"><img src="/IStudy/Public/images/g2.jpg" alt="" /></a>
                            <div class="time small-time">
                                <p>5:34</p>
                            </div>
                            <div class="clck small-clck">
                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="resent-grid-info recommended-grid-info video-info-grid">
                            <h5><a href="single.html" class="title">Varius sit sed viverra nullam viverra nullam interdum metus</a></h5>
                            <ul>
                                <li><p class="author author-info"><a href="#" class="author">John Maniya</a></p></li>
                                <li class="right-list"><p class="views views-info">2,114,200 views</p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 resent-grid recommended-grid">
                        <div class="resent-grid-img recommended-grid-img">
                            <a href="single.html"><img src="/IStudy/Public/images/g3.jpg" alt="" /></a>
                            <div class="time small-time">
                                <p>6:55</p>
                            </div>
                            <div class="clck small-clck">
                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="resent-grid-info recommended-grid-info video-info-grid">
                            <h5><a href="single.html" class="title">Nullam interdum metus viverra nullam varius sit sed viverra</a></h5>
                            <ul>
                                <li><p class="author author-info"><a href="#" class="author">John Maniya</a></p></li>
                                <li class="right-list"><p class="views views-info">2,114,200 views</p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
                <div class="recommended-grids">
                    <div class="col-md-3 resent-grid recommended-grid">
                        <div class="resent-grid-img recommended-grid-img">
                            <a href="single.html"><img src="/IStudy/Public/images/we2.jpg" alt=""></a>
                            <div class="time small-time">
                                <p>7:30</p>
                            </div>
                            <div class="clck small-clck">
                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="resent-grid-info recommended-grid-info video-info-grid">
                            <h5><a href="single.html" class="title">Varius sit sed viverra nullam viverra nullam interdum metus</a></h5>
                            <ul>
                                <li><p class="author author-info"><a href="#" class="author">John Maniya</a></p></li>
                                <li class="right-list"><p class="views views-info">2,114,200 views</p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 resent-grid recommended-grid">
                        <div class="resent-grid-img recommended-grid-img">
                            <a href="single.html"><img src="/IStudy/Public/images/we1.jpg" alt=""></a>
                            <div class="time small-time">
                                <p>9:34</p>
                            </div>
                            <div class="clck small-clck">
                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="resent-grid-info recommended-grid-info video-info-grid">
                            <h5><a href="single.html" class="title">Nullam interdum viverra nullam metus varius sit sed viverra</a></h5>
                            <ul>
                                <li><p class="author author-info"><a href="#" class="author">John Maniya</a></p></li>
                                <li class="right-list"><p class="views views-info">2,114,200 views</p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 resent-grid recommended-grid">
                        <div class="resent-grid-img recommended-grid-img">
                            <a href="single.html"><img src="/IStudy/Public/images/we4.jpg" alt=""></a>
                            <div class="time small-time">
                                <p>5:34</p>
                            </div>
                            <div class="clck small-clck">
                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="resent-grid-info recommended-grid-info video-info-grid">
                            <h5><a href="single.html" class="title">Varius sit sed viverra nullam viverra nullam interdum metus</a></h5>
                            <ul>
                                <li><p class="author author-info"><a href="#" class="author">John Maniya</a></p></li>
                                <li class="right-list"><p class="views views-info">2,114,200 views</p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 resent-grid recommended-grid">
                        <div class="resent-grid-img recommended-grid-img">
                            <a href="single.html"><img src="/IStudy/Public/images/we3.jpg" alt=""></a>
                            <div class="time small-time">
                                <p>6:55</p>
                            </div>
                            <div class="clck small-clck">
                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="resent-grid-info recommended-grid-info video-info-grid">
                            <h5><a href="single.html" class="title">Nullam interdum metus viverra nullam varius sit sed viverra</a></h5>
                            <ul>
                                <li><p class="author author-info"><a href="#" class="author">John Maniya</a></p></li>
                                <li class="right-list"><p class="views views-info">2,114,200 views</p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>

    </div>
    <!-- footer -->
    <div class="footer">
        <div class="footer-grids">
            <div class="footer-top">
                <div class="footer-top-nav">
                    <div class="copyright">
                        <p>Copyright &copy; 2018.shenyu All rights reserved.<a target="_blank" href="#"></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //footer -->
</div>
<!-- main end-->

<div class="clearfix"> </div>
<div class="drop-menu">
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu4">
        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Regular link</a></li>
        <li role="presentation" class="disabled"><a role="menuitem" tabindex="-1" href="#">Disabled link</a></li>
        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another link</a></li>
    </ul>
</div>
</body>
</html>