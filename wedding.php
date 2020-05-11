<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PERFECT WEDDING</title>
    <!--make sure css refresh everytime the site is visited by add time-->
    <link rel="stylesheet" href="css/wedding_style.css?v=<?php echo time();?>">
    <script>
        function entering(name, data) {
            if (data.length == 0) {
                // do nothing if nothing is entered
                document.getElementById("venue_result_table").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    // ready to transmit
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("venue_result_table").innerHTML = this.responseText;
                    }
                };
                // use request label "q"
                xmlhttp.open("GET", "venueQuery.php?q=" + name + "/" + data, true);
                xmlhttp.send();
            }
        }
    </script>
</head>
<body>
	<header class="tm-header">
		<div class="tm-container">
			<div class="title">
				PERFECT WEDDING
			</div>

			<nav class="tm-nav">
                <ul>
					<li><a href="">Home</a></li>
                    <li><a href="aboutPage/about.html">About</a></li>
                </ul>
			</nav>
		</div>

	</header>
	<div class="tm-container">
		<div class="tm-content">
			<article>
                <img src="assets/rose01.png" style="width: 100%;">
                <!-- attribute to image author-->
                <a href="https://www.vecteezy.com/free-vector/rose">Rose Vectors by Vecteezy</a>
                <h1 style="padding-left: 20px;font-family: unset;padding-top: 20px;">
					Welecome to PERFECT WEDDING planning site, we are here to help you to make your wedding the best experience ever!
				</h1>
			</article>

			<article id="wedding_venue_search">
                <h2>Search for your wedding venue</h2>
                <!-- reload wedding.php page to update the info -->
                <form action="wedding.php#wedding_venue_search" method="get" id="venue_search">
                    <table border="0">
                    <tr>
                        <td><label for="date">Date as dd/mm/yyyy</label></td>

                        <td>
                        <input name="date" type="text" class="larger" id="date" value="" onkeyup="entering(this.name, this.value)" size="12" />
                        </td>
                    </tr>
                    <tr>
                        <td><label for="party_size">How many guests?</label></td>
                        <td><input name="party_size" type="text" class="larger" id="party_size" value="" onkeyup="entering(this.name, this.value)" size="5" /></td>
                    </tr>
                    <tr>
                        <td><label for="catering_grade">Minimal Catering Grade? [1 to 5]</label></td>
                        <td><input name="catering_grade" type="text" class="larger" id="catering_grade" value="" onkeyup="entering(this.name, this.value)" size="5" /></td>
                    </tr>
                    </table>
                </form>
            </article>
            
            <article id="wedding_venue_result">
                <h2>Venues that match your needs</h2>
                <table id="venue_result_table" border="0">
                    
                </table>
            </aritcle>
		</div>

		<!-- padding-top: 0px is especially for this sidebar since a drawing will be put on it -->
		<aside class="tm-sidebar" style="padding-top: 0px;">
			<div>
				<h3>MENU</h3>
				<p><a class="linkButton" href="#wedding_venue_search">wedding venue search</a>
			</div>
		</aside>
	</div>

	<footer class="tm-footer">
		&copy; copyright LIN ZEXIN 2020
	</footer>
</body>
</html>
