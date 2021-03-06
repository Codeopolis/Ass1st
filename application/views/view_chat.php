<script type="text/javascript" src="<?php echo base_url(); ?>script/chat.js"></script>

<script type="text/javascript">

var chat_id = "<?php if(isset($user_id)) echo $chat_id; ?>";
var user_id = "<?php if(isset($playerid)) echo $playerid; ?>";

</script>

<style type="text/css">

div#chat_viewport {
	font-family:Verdana, Arial, sans-serif;
	padding:5px;
	color:black;
	height:350px;
	overflow:auto;
	margin-bottom:10px;
	width:100%;
	}

div#chat_viewport ul {
	list-style-type:none;
	padding-left:10px;
}

div#chat_viewport ul li {
	margin-top:10px;
	width:85%;
}

span.chat_message_header {
	font-size:0.7em;
	font-family:"MS Trebuchet", Arial, sans-serif;
	color:#547980;
}

p.message_content {
	margin-top:0px;
	margin-bottom:5px;
	padding-left:10px;
	margin-right:0px;
	}

input#chat_message {
	margin-top:5px;
	border:1px solid #585858;
	width:70%;
	font-size:1.2em;
	margin-right:10px;
}

input#submit_message {
	font-size:2em;
	padding:5px 10px;
	vertical-align:top;
	margin-top:5px;
}

div#chat_input { margin-bottom:10px; }

div#chat_viewport ul li.by_current_user span.chat_message_header {
	color:#e9561b;
	}

</style>



<div id="chat_input">
	<input id="chat_message" name="chat_message" type="text" value="" tabindex="1" />
	<?php echo anchor('#', 'Say it', array('title' => 'Send this chat message', 'id' => 'submit_message'));?>
	<div class="clearer"></div>
</div>

<div id="chat_viewport"></div>

