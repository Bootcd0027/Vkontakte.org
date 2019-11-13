<!-- Layout.css is the template style,menu.css and menu.js are for apycom menu, purr.css and purr.js are for notifications.login.js is for login-->
	<link href="/Major_Project/Common/layout.css" rel="stylesheet" type="text/css" />
	<link type="text/css" href="/Major_Project/Common/Menu/menu.css" rel="stylesheet" />
	<link type="text/css" href="/Major_Project/Common/purr/purr.css" rel="stylesheet" />
	<script type="text/javascript" src="/Major_Project/Common/jquery.js"></script>
	<script type="text/javascript" src="/Major_Project/Common/Login/login.js" ></script>
	<script type="text/javascript" src="/Major_Project/Common/Menu/menu.js"></script>
	<script type="text/javascript" src="/Major_Project/Common/purr/jquery.purr.js"></script>
	<!-- Style for login dialog box -->
	<style type="text/css" >
		#dialog1 input::-webkit-input-placeholder {
		    color:    #000;
		}
		#dialog1 input:-moz-placeholder {
		    color:    #000;
		}
		#mask {
		  position:absolute;
		  left:0;
		  top:0;
		  z-index:9000;
		  background-color:#000;
		  display:none;
		}
		  
		#boxes .window {
		  position:absolute;
		  left:0;
		  top:0;
		  width:440px;
		  height:200px;
		  display:none;
		  z-index:9999;
		  padding:20px;
		}

		#boxes #dialog1 {
		  width:375px; 
		  height:203px;
		}

		#dialog1 .d-header {
		  background:url(/Major_Project/Common/Login/images/login-header.png) no-repeat 0 0 transparent; 
		  width:375px; 
		  height:150px;
		}

		#dialog1 .d-header input {
		  position:relative;
		  top:60px;
		  left:100px;
		  border:3px solid #cccccc;
		  height:22px;
		  width:200px;
		  font-size:15px;
		  padding:5px;
		  margin-top:4px;
		}

		#dialog1 .d-blank {
		  float:left;
		  background:url(/Major_Project/Common/Login/images/login-blank.png) no-repeat 0 0 transparent; 
		  width:267px; 
		  height:53px;
		}

		#dialog1 .d-login {
		  float:left;
		  width:108px; 
		  height:53px;
		}
	</style>
