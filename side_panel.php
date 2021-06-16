<style>
	#side_panel {
		background-color: #212121;
		position: fixed;
    	display: flex;
    	flex-direction: column;
    	align-items: center;
		transition: all 500ms linear;
		margin-top: 60px;
		height: 100%;
		width: 120px;
	}

	.side_items {
	    margin: 15px;
	    border: 1px solid #212121;
	    padding-top: 10px;
	    text-align: center;
	    width: 90%;
	}

	.side_items:hover {
	    border: 1px solid gray;
	}

</style>

<div id="side_panel">
	<div class="side_items"><a href="homepage.php"><img src="img/home.png" alt="home_button" width="35" height="55"></a></div>
	<div class="side_items"><img src="img/trending.png" alt="trending_button" width="50" height="55"></div>
	<div class="side_items"><img src="img/subscriptions.png" alt="subscription_button" width="80" height="50"></div>
	<div class="side_items"><a href='user_profile.php?op=1'><img src="img/library.png" alt="library_button" width="45" height="50"></a></div>
</div>