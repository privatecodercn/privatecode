<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <title>Please Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <style>
	body {
	
	    padding-top: 40px;
	    padding-bottom: 40px;
	    background-color: #f5f5f5;
	}
	
	.form-signin {
		background:black;
	    max-width: 300px;
	    padding: 19px 29px 29px;
	    background-color: #fff;
	    border: 1px solid #e5e5e5;
	    -webkit-border-radius: 5px;
	    -moz-border-radius: 5px;
	    border-radius: 5px;
	    -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
	    -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
	    box-shadow: 0 1px 2px rgba(0,0,0,.05);
		position:absolute;
		top:35%;
		left:50%;
		margin:-150px 0 0 -100px;
		width:300px;
		height:270px;
	}
	.form-signin .form-signin-heading,
	.form-signin .checkbox {
	    margin-bottom: 10px;
	}
	.form-signin input[type="text"],
	.form-signin input[type="password"] {
	    display: inline-block;
	    height: auto;
		margin: 0;
	    margin-bottom: 15px;
	    padding: 7px 9px;
		letter-spacing: normal;
		word-spacing: normal;
		text-transform: none;
		text-indent: 0px;
		text-shadow: none;
		text-align: start;
		-webkit-appearance: textfield;
		-webkit-rtl-ordering: logical;
		-webkit-user-select: text;
		cursor: auto;
		width: 100%;
		min-height: 30px;
		box-sizing: border-box;
		line-height: 20px;
		color: #555555;
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		border-radius: 4px;
		background-color: #ffffff;
		border: 1px solid #cccccc;
		-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		-webkit-transition: border linear .2s, box-shadow linear .2s;
		-moz-transition: border linear .2s, box-shadow linear .2s;
		-o-transition: border linear .2s, box-shadow linear .2s;
		transition: border linear .2s, box-shadow linear .2s;
		font: -webkit-small-control;
	    font-size: 14px;
	    font-weight: normal;
		vertical-align:middle;
	}
	.form-signin #captcha{
		width:150px;
		vertical-align:middle;
	}
	label {
		display: block;
		margin-bottom: 5px;
	}
	label, input, button, select {
	    font-family: "微软雅黑", "Microsoft YaHei", SimSun, "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-weight: normal;
		line-height: 20px;
		-webkit-writing-mode: horizontal-tb;
		font: -webkit-small-control;
		letter-spacing: normal;
		word-spacing: normal;
		text-transform: none;
		text-indent: 0px;
	}
	button {
		display: inline-block;
		-webkit-align-items: flex-start;
		box-sizing: border-box;
		margin-bottom: 0;
		line-height: 20px;
		text-align: center;
		vertical-align: middle;
		cursor: pointer;
		box-shadow: inset 0 1px 0 rgba(255,255,255,.2), 0 1px 2px rgba(0,0,0,.05);
		-webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,.2), 0 1px 2px rgba(0,0,0,.05);
		padding: 11px 19px;
		font-size: 18px;
		-webkit-border-radius: 6px;
		-moz-border-radius: 6px;
		border: 1px solid #bbbbbb;
		border-radius: 6px;
		border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
		color: #ffffff;
		text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
		background-color: #006dcc;
		background-image: linear-gradient(to bottom, #0088cc, #0044cc);
		background-repeat: repeat-x;
	}
    </style>


    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->

  </head>

  <body>

    <div class="container">

      <form id="loginform" class="form-signin" action="/admin/doLogin" method="post">
        <h2 class="form-signin-heading">Please Login</h2>
        <input type="text" id="username" name="username" class="input-block-level" placeholder="Admin User">
        <input type="password" id="password" name="password" class="input-block-level" placeholder="Admin Password">
        <input type="text" id="captcha" name="captcha" class="input-block-level captcha" placeholder="Captcha">
        <img id="captchaimg" src="/captcha/index/c/admin_captcha/n/4/m/2/h/30?rnd=<?=rand()?>" onclick="this.src=this.src.substring(0, this.src.lastIndexOf('rnd=')+4)+Math.random()" />
        <br />
        <button class="btn btn-large btn-primary" type="submit">Login</button>
      </form>

    </div> <!-- /container -->


  </body>
</html>
<script src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">window.jQuery || document.write(unescape('%3Cscript src="/assets/js/jquery-2.1.1.min.js"%3E%3C/script%3E'))</script>
<script type="text/javascript">
$(function(){
	$('#loginform').submit(function(){
		var url = $(this).attr('action');
		var data = $(this).serialize();
		$.post(url, data, function(json) {
			if (json.success)
			{
				window.location.href = '/admin';
			} else {
				var captcha = $('#captchaimg');
				var src = captcha.attr('src');
				captcha.attr('src', src.substring(0, src.lastIndexOf('rnd=')+4)+Math.random());
				alert(json.message);
			}
		}, 'json');
		return false;
	});
});
</script>