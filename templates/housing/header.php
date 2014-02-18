
<div id="container">
	<a href="<?=$config[site][url]?>"><img id="logo" src="templates/<?=$config[site][logo]?>" alt="Okinawa Housing" /></a>
	<ul id="nav">
		<ul>
			<li class="<? if($_GET['p']==''){echo 'current_page_item';}else{echo 'page_item';}?>"><a href="<?=$config[site][url]?>">Home</a></li>
			<li class="<? if($_GET['p']=='search'){echo 'current_page_item';}else{echo 'page_item';}?>"><a href="?p=search" title="View all posts filed under Find a Home">Find a Home</a></li>
			<li class="<? if($_GET['p']=='about'){echo 'current_page_item';}else{echo 'page_item';}?>"><a href="?p=about" title="About">About</a></li>
			<li class="<? if($_GET['p']=='contact'){echo 'current_page_item';}else{echo 'page_item';}?>"><a href="?p=contact" title="Services">Contact</a></li>
			<?
				if(!$_SESSION[id]){
					echo '<li class="';
					if($_GET['p']=='login'){echo 'current_page_item';}else{echo 'page_item';}
					echo '"><a href="?p=login" title="Contact">Login</a></li>';
				} else {
					echo '<li class="';
					if($_GET['p']=='desktop'){echo 'current_page_item';}else{echo 'page_item';}
					echo '"><a href="?p=desktop" title="Desktop">Desktop</a></li>';
				}
			?>
		</ul>
	</ul>
	<div id="search">
		<p class="left">Browse Online or Call Us: On Base: 632.0096 / OffBase: 098.962.0096</p>
		<div id="searchfield">
			<!-- <span class="right"><a href="?p=browse&cat=1">Single Homes</a> | <a href="?p=browse&cat=2">Apartments</a> | <a href="?p=browse&cat=3">Duplexes</a></span> -->
		</div>
	</div>
	<div id="homeheader" <? if($_GET['p'] != '') echo 'style="display:none;"';?>>
	
		<img src="templates/<?=$config[site][template]?>/images/header_home_img1.jpg" alt="Okinawa Housing" />
		<div id="homeintro">
		<!-- Search Box -->
			<h1>Start your search</h1>
          	<form method="post" name="search" action="?p=search">
                <input type="hidden" name="action" value="search" />
                <table border="0"  cellspacing="0" class="search">
                	<tr><th>Type: </th><td><select name="type">
                						<option value="0" selected="selected">Any</option>
                						<option value="1" >Single Home</option>
                						<option value="2" >Apartment</option>
                						<option value="3" >Duplex</option>
                						</select></td></tr>
                     <tr><th>Price Range: </th><td>
                     <select name="min_price">
                     	<option value="0" selected="selected">Any</option>
                     	<option value="0">0</option>
                     	<option value="140000">140,000</option>
                     	<option value="150000">150,000</option>
                     	<option value="155000">155,000</option>
                     	<option value="160000">160,000</option>
                     	<option value="165000">165,000</option>
                     	<option value="180000">180,000</option>
                     	<option value="190000">190,000</option>
                     	<option value="200000">200,000</option>
                     	<option value="210000">210,000</option>
                     	<option value="225000">225,000</option>
                     	<option value="235000">235,000</option>
                     	<option value="240000">240,000</option>
                     	<option value="250000">250,000</option>
                     	<option value="280000">280,000</option>
                     	<option value="300000">300,000</option>
                     	<option value="320000">320,000</option>
                     </select>~<select name="max_price">
                     	<option value="0" selected="selected">Any</option>
                     	<option value="0">0</option>
                     	<option value="140000">140,000</option>
                     	<option value="150000">150,000</option>
                     	<option value="155000">155,000</option>
                     	<option value="160000">160,000</option>
                     	<option value="165000">165,000</option>
                     	<option value="180000">180,000</option>
                     	<option value="190000">190,000</option>
                     	<option value="200000">200,000</option>
                     	<option value="210000">210,000</option>
                     	<option value="225000">225,000</option>
                     	<option value="235000">235,000</option>
                     	<option value="240000">240,000</option>
                     	<option value="250000">250,000</option>
                     	<option value="280000">280,000</option>
                     	<option value="300000">300,000</option>
                     	<option value="320000">320,000+</option>
                     	</select></td></tr>
                     <tr><th>Nearest Base: </th><td><select name="base"><option value="0" selected="selected">Any</option><option value="1" >Kinser</option><option value="2" >Futenma</option><option value="3" >Foster</option><option value="4" >Lester</option><option value="5" >Kadena</option><option value="6" >Torii Station</option><option value="7" >McTureous</option><option value="8" >Courtney</option><option value="9" >Schwab</option><option value="10" >Hansen</option></select></td></tr>
                     <tr><th>Bedrooms: </th><td><select id="bed" name="bed">
     	<option value="0" selected="selected">Any</option>
    		<option value="1">1</option>
    		<option value="2">2</option>
    		<option value="3">3</option>
    		<option value="4">4</option>
    		<option value="5">5</option>
    		<option value="6">6+</option>
    	</select></td>
                     </tr>
                     <tr>
                              <th>Bathrooms: </th>
                              <td><select id="bath" name="bath">
          <option value="0">Any</option>
    		<option value="1">1</option>
    		<option value="1.5">1.5</option>
    		<option value="2">2</option>
    		<option value="2.5">2.5</option>
    		<option value="3">3</option>
    		<option value="3.5">3.5</option>
    		<option value="4">4+</option>
    	</select></td>
               	</tr>
                	<tr>
                    		<th><input type="submit" value="Search" /></th>
                            <th style="text-align:left;">&nbsp;</th>
                    </tr>
            	</table>
                </form>

			<!--<p>Whether you're looking to rent a new House, Apartment, or Duplex, we have you covered. Let us help you find your dream home today.</p>
			<a id="btnleft" href="?p=search">Find a Home</a>
			<a id="btnright" href="?p=contact">Contact Us</a> -->

		</div>
	</div>