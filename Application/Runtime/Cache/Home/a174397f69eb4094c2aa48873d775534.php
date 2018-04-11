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
    
    <div class="row">
        <div class="col-sm-8 col-md-8">
            <form id="course">
                <div class="form-group">
                    <label for="title">课程名</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="课程名不超过50字">
                    <span class="msg-box" id="titleMsg"></span>
                </div>
                <div class="form-group">
                    <label for="brief">课程简介</label>
                    <textarea class="form-control" id="brief" name="brief" placeholder="介绍下你的课程吧" high="300px"></textarea>
                </div>
            </form>
        </div>
        <script>
            $('#course').validator({
                fields: {
                    title: {
                        rule: "required; length(~50)",
                        msg: {
                            required: "课程名必填",
                        },
                        ok: "",
                        timely: 1,
                        target: "#titleMsg",
                    },
                },
                valid: function(form) {
                    $.ajax({
                        url: "/IStudy/index.php/Home/Login/login",
                        type: "POST",
                        async: true,
                        data: $("#course").serialize(),
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
        </script>
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