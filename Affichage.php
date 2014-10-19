<script type='text/javascript'>

	function test(){
		alert('Attention le prix de la promotion doit être inférieur au prix d\'origine, si ce n\'est pas le cas, votre promotion ne sera pas insérée !!!! ');
	} 
    function writediv(texte) {
      document.getElementById('pseudobox').innerHTML = texte;
    }
 
    function verifPseudo(pseudo) {
		if (pseudo != '') {
			if (texte = file('./verif.php?pseudo='+escape(pseudo))) { 
				if (texte == 1){
					writediv('<span style="color:#cc0000"><b>'+pseudo+' :</b> ce pseudo est deja pris</span>');
				}else if(texte == 0){
					writediv(texte);
					writediv('<span style="color:#1A7917"><b>'+pseudo+' :</b> ce pseudo est libre</span>');
				}else{
					writediv(texte);
				}
			}
		}
	}
 
    function file(fichier) {
      if (window.XMLHttpRequest) // FIREFOX
        xhr_object = new XMLHttpRequest();
      else if(window.ActiveXObject) // IE
        xhr_object = new ActiveXObject("Microsoft.XMLHTTP" );
      else
        return(false);
      xhr_object.open("GET", fichier, false);
      xhr_object.send(null);
      if (xhr_object.readyState == 4) 
        return xhr_object.responseText;
      else 
        return false;
    }

</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php
	session_start();

    function menu(){
		
		if(isset($_SESSION['profil']['com'])){
			$tab_menu_link = array( "PromoSphere.php", "PromoSphere.php?a=SignalerProm", "PromoSphere.php?a=Ajoutmag", "PromoSphere.php?a=toutePromo", "PromoSphere.php?a=AfficherPanier", "PromoSphere.php?a=mesprom");
			$tab_menu_txt = array( "Accueil", "Signaler une promotion", "Ajouter magasin", "Les promotions", "Liste de shopping", "Mes promotions");
		}else if(isset($_SESSION['profil']['cli'])){
			$tab_menu_link = array( "PromoSphere.php", "PromoSphere.php?a=SignalerProm", "PromoSphere.php?a=toutePromo", "PromoSphere.php?a=AfficherPanier", "PromoSphere.php?a=mesprom");
			$tab_menu_txt = array( "Accueil", "Signaler une promotion", "Les promotions", "Liste de shopping", "Mes promotions");
		}else{
			$tab_menu_link = array( "PromoSphere.php","PromoSphere.php?a=toutePromo");
			$tab_menu_txt = array( "Accueil", "Les promotions");
		}
        
        $menu="";
        $info = pathinfo($_SERVER['PHP_SELF']);
        
        foreach($tab_menu_link as $cle=>$lien){
            $menu .= "   <li";
            
            if($info['basename'] == $lien){
                $menu .=" class=\"active\"";
            }
                
            $menu .= "><a href=\"" . $lien . "\">" . $tab_menu_txt[$cle] . "</a></li>\n";
            
        }
        
        return $menu;
    }
?>


<?php

	include_once 'Article.php';
	include_once 'liste.php';
	include_once 'Client.php';
	include_once 'Magasin.php';
	include_once 'Commercant.php';
	
	class Affichage{

		public static function BarreNav(){         
		   require_once("./Affichage.php");
           $menu = menu();
            
           echo'<nav class="navbar navbar-inverse" role="navigation" >
					<div class="row">
						<div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 col-lg-10 col-md-10 col-sm-10 col-xs-10">
							<div class = "col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    
								<img id="logo" src="inQontrol_qdance.png" style="max-height:75px; max-width:75px; float:left;"/>
									<h1 class="col-lg-4  col-md-4 col-sm-4 col-xs-4" style="color:red;">Promo Sphère</h1>
									<div class="col-lg-6  col-md-6 col-sm-6 col-xs-6" style="margin-top:1%">
										<ul class="nav navbar-nav">';
            echo $menu;
			
			echo'						</ul> 
									</div>           
								</div>';
					
			if(isset($_SESSION['profil'])){
				echo'			<div class="col-lg-2  col-md-2 col-sm-2 col-xs-2">
									<br>
									<div class="col-lg-6  col-md-6 col-sm-6 col-xs-6"><p id="connecte">Bonjour ' . $_SESSION['profil']['prenom'] .'</p></div>
									<a class="col-lg-6  col-md-6 col-sm-6 col-xs-6" href="PromoSphere.php?a=Deconnexion"><p class="log">Deconnexion</p></div></a>

								</div>
							</div>
					</nav>';	
			}else{
				echo	'		<div class="col-lg-2  col-md-2 col-sm-2 col-xs-2">
									<br>
									<a class="col-lg-6  col-md-6 col-sm-6 col-xs-6" href="PromoSphere.php?a=Connexion"><p class="log">Se connecter</p></a>
									<a class="col-lg-6 col-md-6 col-sm-6 col-xs-6" href="PromoSphere.php?a=Inscription"><p class="log">S\'inscrire</p></a>
								</div>
							</div>
					</nav>';
			}
		}
		
		
		public static function Accueil(){
      Affichage::Description();
      echo ' <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 col-lg-10 col-md-10 col-sm-10 col-xs-10">
      
      <div id="lastProd">Les derniers produits signalés...</div><br></div><div>';
			Affichage::AfiAll();
			
		$b = Base::getConnection();
			$save_query = "DELETE FROM events WHERE date < CURDATE();";
			try{
				$stmt = $b->prepare($save_query);
				$a = $stmt->execute();
				return $a;
			}catch (PDOException $e){
				return null;
			}
      echo '</div>';

		}
    
      public static function Description(){
     echo ' <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 col-lg-10 col-md-10 col-sm-10 col-xs-10">
              <p id="descHead"> Qu\'est ce que Promosphère ?:</p>
              <p class="descCorp">Promosphère est un site sur lequel chaque utilisateur peut recenser des promotions et/ou retrouver des promotions constatées dans le magasin ou il se trouve.</p>
              <p class="descCorp">Il est également possible de créer une liste d\'achat à effectuer nommé "Liste de shopping" afin que vous puissiez garder en mémoire les articles qui vous ont intéressés...</p> 
            <hr style="border-color: black; box-shadow: 0px 0px 3px black; border-style: groove; border-radius: 6px; border-bottom-width: 2px;"></div><br>';
    }
   
		public static function Connexion(){
			
			echo '<div>';
				echo '<form action="Connexion.php" method="post">
                    <div class="row">
                        <br><br><br>
                        <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-xs-offset-2 col-lg-8  col-md-8 col-sm-8 col-xs-8">
					            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label for="Login">Login</label>
                                </div>
					            <input type="text" name="login" value=""/><br><br>

                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					                <label for="mdp">Mot de passe</label>
                                </div>    
					            <input type="password" name="mdp" value=""/><br><br>

					            <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4"><input type="submit" value="Se connecter"/ class="btn btn-primary"></div>
                            </div>    
                        </div>
                    </div>
					</form>';			
			echo '</div>';
		}
		
		public static function Deconnexion(){
			unset($_SESSION['profil']);
			session_unset();
			session_destroy();
			header ('Location: PromoSphere.php?a=accueil');
		}
		
		public static function Inscription(){
			echo '<div class="row"><br><br><br>
                    <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-4 col-md-4 col-sm-4 col-xs-4"><div class="col-lg-offset-2 col-lg-8 col-md-8 col-sm-8 col-xs-8">
			        <form action="Inscription.php" method="post">
			
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
				        <label for="Login">Login</label>
                    </div>
				    <input type="text" name="pseudo" value="" maxlength="50" onKeyUp="verifPseudo(this.value)" required/><br><br>
					<div id="pseudobox"></div>
				
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
				        <label for="mdp">Mot de passe</label>
                    </div>
				    <input type="password" name="mdp" value="" maxlength="32" required/><br><br>
				
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
				        <label for="prenom">Prenom</label>
                    </div>
				    <input type="text" name="prenom" value="" maxlength="50" required/><br><br>
					
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
				        <label for="nom">Nom</label>
                    </div>
				    <input type="text" name="nom" value="" maxlength="50" required/><br><br>

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
				        <label for="email">Email</label>
                    </div>
				    <input type="email" name="email" value="" maxlength="50" required/><br><br>
					
					<td><b>Type</b></td>  
					<td><input type=radio value="particulier" name="type" id="particulier" required/>Particulier
					  <input type=radio value="commercant" name="type" id="commercant required">Commercant
					  </select>
					</td>
					
					<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4">
					<input type="submit" value="S inscrire"  "class="btn btn-primary"/></div>
				    </form>
                    </div></div>
			    </div>';
		}
		
		//Affiche un article
		public static function Afi($art){
			echo '  <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 col-lg-10 col-md-10 col-sm-10 col-xs-10" style="border-style:solid; border-radius: 5px; box-shadow: 5px 5px 15px black;">	 
						<div class="row" style="background:#F0EAE7;">
							<div class="bigbox">
								<h2 class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 col-lg-5 col-md-5 col-sm-5 col-xs-5">'. $art->nom_article .'</h2>  <!-- Nom du produit -->                    
								<div class="row"> <!-- box affichant les informations du produit -->
									<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-8 col-md-8 col-sm-8 col-xs-8">             
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" >
											<br><br>
											<img class="img-circle img-responsive" src="'. $art->photo .'" />
										</div>  <!-- fin de div contenant img --> 
                    <!-- Box contenant les informations relatives au produit -->
										<div class="col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-xs-offset-3 col-lg-5 col-md-5 col-sm-5 col-xs-5" style="border-style:solid; border-radius: 5px; box-shadow: 5px 5px 15px black; background:#B8ABA5;width: 50%;">
											<div class="descr-box" style="font-size:inherit; text-shadow:inherit; font-weight:bolder;">
												<br>
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Prix: <del>'. $art->prix .'</del> '. $art->prix_promo .'</div>
												</div>';
												
			$mag = new Magasin();
			$mag = Magasin::findById($art->id_magasin);
			
			echo '								<hr color="grey">';
			
			//Indique le nom/enseigne de la personne qui a mis l'article en ligne
			if($art->id_client != null){
			    $cli = new Client();
			    $cli = Client::findById($art->id_client);
			     echo '							Mise en ligne par <b>'. $cli->login_client .'</b>.';
			}else{
				if($art->id_magasin != null){
					echo '						Mise en ligne par <b>☆'. $mag->nom_magasin .'</b>.';
				}
			}
			
			echo '								<hr color="grey">';
			
			//Date de promotion
			echo'								En promotion du '. $art->datedebut .' au '. $art->datefin.'
												<div class="row">';
                                           
			if($art->id_magasin != null){
				echo '								<hr color="grey">';
			
				echo ' 								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> Ce produit est disponible à '. $mag->nom_magasin .'</div>
												</div>
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Au '. $mag->numero .', '. $mag->rue .', '. $mag->ville .'</div>
												</div>';
			}else{
				echo ' 								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
												</div>
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
												</div>';								
			}
			
			if((isset($_GET['a']) && $_GET['a'] != 'mesprom') || !isset($_GET['a'])){
				//Ajout bouton liste
				if(isset($_SESSION['profil'])){
					$count = liste::countArtById($_SESSION['profil']['userid'],$art->id_article);
					
					if($count['nombre']  == 0){
						echo'					<br><a class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4" href="PromoSphere.php?a=addLs&idart='. $art->id_article .'"><button class="btn btn-primary">Ajouter à la liste</button><br></a>';
					}else{
						echo'					<br><a class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4" href="PromoSphere.php?a=supLs&idart='. $art->id_article .'"><button class="btn btn-primary">Retirer de la liste</button><br></a>';
					}
				}	
			}
			
			if(isset($_GET['a']) && $_GET['a'] == 'mesprom'){
				
				//bouton suppression et modification
				if( (isset($_SESSION['profil']['cli']) && $_SESSION['profil']['userid'] == $art->id_client) || isset($_SESSION['profil']['com'])){
					
					echo'							<br><a href=PromoSphere.php?a=modifProm&idart='. $art->id_article .'>
														<div class="row"><br>
															<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4"><button class="btn btn-primary">Modifier la promotion</button></div>
														</div>
													</a>';			
					
					echo'							<div class="row"><br>
														<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4">Ce bon plan n\'existe plus ? <br><a class="col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-xs-offset-2" href="PromoSphere.php?a=supProm&idart='. $art->id_article .'"><button class="btn btn-primary">Supprimer</button> </a>
															<div>
															</div>
														</div>
													</div><br>';
				}else{
				
					echo'							<div class="row"><br>
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
													</div>';
													
					echo'							<div class="row"><br>
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
															<div>
																
															</div>
														</div>
													</div>';
				}
			}
			
			//description,taille et couleur
			echo'							</div>
										</div>
									</div>
								</div>
								<hr />
								<div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-xs-offset-2 col-lg-8 col-md-8 col-sm-8 col-xs-8">
									<div class="descr-box">Description : '.	$art->description.' <br>
										Taille(s): '. $art->taille_dispo .
										'<br>'. 'Couleur: '. $art->couleur .'<br><br>
									</div>
								</div>
								<br><br>
							</div>
						</div>
					</div>';
		}
		
		//affiche tous les article
		public static function AfiAll(){
            echo'<div class="row">
                    <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 col-lg-10 col-md-10 col-sm-10 col-xs-10">';
				foreach (Article::findAll() as $art) {
					Affichage::Afi($art);
                    echo'<div class="row"><div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 col-lg-10 col-md-10 col-sm-10 col-xs-10"><hr / style="visibility:hidden;"></div></div>';
				}
            echo'</div></div>';    
		}
		
		public static function Mesprom(){
			echo'<div class="row">
                    <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 col-lg-10 col-md-10 col-sm-10 col-xs-10">';
			foreach (Article::findByIdAuteur() as $art) {
				Affichage::Afi($art);
                echo'<div class="row"><div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 col-lg-10 col-md-10 col-sm-10 col-xs-10"><hr / style="visibility:hidden;"></div></div>';
			}
            echo'</div></div>'; 
		}
		
		public static function AfiLs(){
			if(isset($_SESSION['profil'])){
				$temp = 0;
				foreach(Liste::findArtByIdCli($_SESSION['profil']['userid']) as $lis){
					$a = new Article();
					$a = Article::findById($lis->id_article);
					Affichage::Afi($a);
					$temp++;                    
				}
				if($temp == 0){
					echo '<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-6 col-md-6 col-sm-6 col-xs-6">Votre liste est vide</div>';
				}
				
			}
		
		}
		
		public static function AjoutListe($idart){
				liste::ajoute($idart,$_SESSION['profil']['userid']);
		}
		
		
    
    
		public static function NouvelPromo(){
			echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
			echo '	<form action="NvPromo.php" method="post" enctype="multipart/form-data">
			  
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-2 col-md-2 col-sm-2 col-xs-2"><div id="lastProd">Ajouter une nouvelle promotion :</div></div><br><br><br>
								<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
									<label for="cbarre">code barre</label>
								</div>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
									<input type="text" name="cbarre" value="" maxlength="50"/>
								</div>
							</div>
							<br><br>
				
							<div class="row">
								<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
									<label for="narticle">Nom de l\'article</label>
								</div>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
									<input type="text" name="narticle" value="" maxlength="50" required/>
								</div>
							</div>
							<br><br>
				
							<div class="row">
								<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
									<label for="prix">Prix origine</label>				
								</div>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
									<input type="text" name="prix" value="" maxlength="8" pattern="^[0-9]+(([\.\,])+[0-9]{1,2})?$" required/>
								</div>
							</div>
							<br><br>
				
							<div class="row">
								<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
									<label for="prixprom">Prix promotion</label>
								</div>
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">	
									<input type="text" name="prixprom" value="" maxlength="8" pattern="^[0-9]+(([\.\,])+[0-9]{1,2})?$" required/>
								</div>
							</div>
							<br><br>
				
							<div class="row">
								<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
									<label for="desc">Description</label>
								</div>
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
									<textarea name="desc" rows="5" cols="50" required > </textarea> 
								</div>
						</div>
						<br>
				
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<label for="image">Image produit</label>					
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<input type="file" name="photo" required/>
							</div>
						</div>
						<br><br>
				
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<label for="taille">Taille disponible</label>			
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<input type="text" name="taille" value="" maxlength="100"/>
							</div>
						</div>
						<br><br>
				
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
									<label for="couleur">Couleur</label>			
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<input type="text" name="couleur" value="" maxlength="50"/>
							</div>
						</div>		
						<br><br>
				
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<label for="datedeb">Date début</label>				
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<input type="date" name="datedeb" required>
							</div>
						</div>
						<br><br>
				
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<label for="datefin">Date fin</label>
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<input type="date" name="datefin" required>
							</div>
						</div>
						<br>';		
			if(isset($_SESSION['profil']['com'])){
						
				echo'		<div class="row">
								<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
									<label for="magasin" required>Magasin ?</label><br />
								</div>
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
									<select name="magasin" id="magasin">';
								
				foreach(Magasin::finByIdCom($_SESSION['profil']['userid']) as $mag){
					echo'				<option value="'.$mag->nom_magasin.'">'. $mag->nom_magasin .'</option>';
				}
				
				echo '				</select>';
			}
				echo'			</div>
							</div>
							<div class="row">
								<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">				
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<input type="submit" onclick="verif_INF(prix,prixprom)" value="Valider promo" class="btn btn-primary"/>
							</div>
						</div>
					</form>
				</div>';
		}
		
		public static function ModifPromo($art){
            echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
			echo '<form action="ModifPromo.php?idart='.$art->id_article.'" method="post">
			
                <div class="row">
                <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">	
				<label for="cbarre">code barre</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<input type="text" name="cbarre" value="'.$art->code_barre.'"  maxlength="50"/>
				<br><br>
                </div>
                </div>
				
                <div class="row">
                <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">	
				<label for="narticle">Nom de l\'article</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<input type="text" name="narticle" value="'.$art->nom_article.'"  maxlength="50" required/>
				<br><br>
                </div>
                </div>
				
                <div class="row">
                <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">	
				<label for="prix">Prix origine</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<input type="text" name="prix" value="'.$art->prix.'" maxlength="8" pattern="^[0-9]+(([\.\,])+[0-9]{1,2})?$" required/>
				<br><br>
                </div>
                </div>
					
                <div class="row">
                <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">	
				<label for="prixprom">Prix promotion</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<input type="text" name="prixprom" value="'.$art->prix_promo.'" maxlength="8" pattern="^[0-9]+(([\.\,])+[0-9]{1,2})?$" required/>
				<br><br>
                </div>
                </div>
				
                <div class="row">
                <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">	
				<label for="desc">Description</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<textarea name="desc" rows="5" cols="50" required>'.$art->description.' </textarea> 
				<br>
                </div>
                </div>
				
                <div class="row">
                <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">	
				<label for="image">Image produit</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<input type="file" name="photo" required>'.$art->photo.' </> 
				<br><br>
                </div>
                </div>
				
                <div class="row">
                <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">	
				<label for="taille">Taille disponible</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<input type="text" name="taille" value="'.$art->taille_dispo.'" maxlength="100"/>
				<br><br>
                </div>
                </div>
				
				<div class="row">
                <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">	
				<label for="couleur">Couleur</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<input type="text" name="couleur" value="'.$art->couleur.'" maxlength="50"/>
				<br><br>
                </div>
                </div>
				
                <div class="row">
                <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">	
				<label for="datedeb">Date début</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<input type="date" name="datedeb" required> '.$art->datedebut.' />
				<br><br>
                </div>
                </div>
				
                <div class="row">
                <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">	
				<label for="datefin">Date fin</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<input type="date" name="datefin" required> '.$art->datefin.' />
				<br>
                </div>
                </div>

                <div class="row">
                <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
                </div>
                 <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<input type="submit" value="Valider promo" class="btn btn-primary"/>
                </div>
                </div>
				</form>';
			echo '</div>';
		}
		
		public static function Ajoutmag(){
			echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
			echo'	<form method="post" action="Nvmag.php">
						
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<label for="nom">Nom magasin</label>
								</div>
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
									<input type="text" name="nom" id="nom" maxlength="100" required/><br />
								</div>
							</div>
						<br>
						
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<label for="num">Numero</label>
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<input type="number" name="num" id="num" maxlength="5" required/><br />
							</div>
						</div>
						<br>
						
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<label for="rue">Rue</label>
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<input type="text" name="rue" id="rue"  maxlength="100" required/><br />
							</div>
						</div>
						<br>
						
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<label for="ville">Ville</label>
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<input type="text" name="ville" id="ville" maxlength="50" required/><br />
							</div>
						</div>
						<br>
						
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<label for="cd">Code postal</label>
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<input type="text" name="cd" id="cd" maxlength="5" pattern="^[0-9]{5,5}$" required/><br />
							</div>
						</div>
						<br>
						
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<label for="desc">Description</label>
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<textarea name="desc" rows="5" cols="50"  required> Description </textarea> 
							</div>
						</div>
						<br>
						
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<label for="tel">Tel</label>
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								<input type="tel" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$" required><br />
							</div>
						</div>
						<br>
			
						<div class="row">
							<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 col-lg-1 col-md-1 col-sm-1 col-xs-1">	
								<input type="submit" value="Valider"/>
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
							</div>
						</div>
						<br>
					</form>';
		}
    
   	
	}

?>