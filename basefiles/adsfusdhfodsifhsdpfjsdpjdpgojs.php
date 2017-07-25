<?php
include_once('./basefiles/header.php');
?>
<?php
	require_once './lib/swiftmailer/swift_required.php';

	// Create the Transport
	$transport = Swift_SmtpTransport::newInstance('***REMOVED***', 465, 'ssl')
	  ->setUsername('***REMOVED***')
	  ->setPassword('***REMOVED***')
	  ;

	// Create the Mailer using your created Transport
	$mailer = Swift_Mailer::newInstance($transport);

    $msgTitle = "La mise à jour 0.3.0 de Galactae enfin dévoilée !";

	$msg = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Newsletter Galactae: Space Age Rising</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <style type="text/css">
    /* Fonts and Content */
    body, td { font-family: "Segoe UI Light","Segoe WPC","Segoe UI", Helvetica, Arial, "Arial Unicode MS", Sans-Serif; }
    body { background-color: #FBFBFA; margin: 0; padding: 0; -webkit-text-size-adjust:none; -ms-text-size-adjust:none; color: #dddddd; }
    h2{ padding-top:12px; /* ne fonctionnera pas sous Outlook 2007+ */ font-weight: bold; font-size:22px; text-align: center; color: #00b0ff;}
    a { color: #ffffff; }
    h3 { color: #00b0ff; text-decoration: none; font-size: 26px; }

    li { color: #00b0ff; font-size: 18px; }
    li ul li { color: #dddddd; font-size: 14px;}

    @media only screen and (max-width: 480px) { 

        table[class=w275], td[class=w275], img[class=w275] { width:135px !important; }
        table[class=w30], td[class=w30], img[class=w30] { width:10px !important; }  
        table[class=w580], td[class=w580], img[class=w580] { width:280px !important; }
        table[class=w640], td[class=w640], img[class=w640] { width:300px !important; }
        img{ height:auto;}
         /*illisible, on passe donc sur 4 lignes */
        table[class=w180], td[class=w180], img[class=w180] { 
            width:280px !important; 
            display:block;
        }    
        td[class=w20]{ display:none; }   

    } 
    </style>
   
</head>
<body style="margin:0px; padding:0px; -webkit-text-size-adjust:none;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tbody>
            <tr>
                <td align="center" bgcolor="#1D1D1D">
                    <table  cellpadding="0" cellspacing="0" border="0">
                        <tbody>                            
                            <tr>
                                <td class="w640"  width="640" height="10"></td>
                            </tr>
                            <tr>
                            <td align="center" class="w640"  width="640" height="20" style="font-size:12px;"> <a href="https://***REMOVED***/blog">Voir cette news en ligne</a> </td>
                            </tr>
                            <tr>
                                <td class="w640"  width="640" height="10"></td>
                            </tr>
                            <!-- entete -->
                            <tr class="pagetoplogo">
                                <td class="w640"  width="640">
                                    <table  class="w640"  width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#1D1D1D" style="color: #ffffff">
                                        <tbody>
                                            <tr>
                                                <td class="w30"  width="30"></td>
                                                <td  class="w580"  width="580" valign="middle" align="left">
                                                    <div class="pagetoplogo-content">
                                                        <h2><b>GALACTAE: SPACE AGE RISING</b></h2>
                                                    </div>
                                                </td> 
                                                <td class="w30"  width="30"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <!-- contenu -->
                            <tr class="content">
                                <td class="w640" class="w640"  width="640">
                                    <table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0">
                                        <tbody>
                                            <tr>
                                                <td  class="w30"  width="30"></td>
                                                <td  class="w580"  width="580">
                                                    <!-- une zone de contenu -->
                                                    <table class="w580"  width="580" cellpadding="0" cellspacing="0" border="0">
                                                        <tbody>                                                            
                                                            <tr>
                                                                <td class="w580"  width="580">
                                                                    <div align="left" class="article-content" style="color: #dddddd;">
                                                                        <p align="center">Bonjour à tous !</p>
                                                                        <p>Il y a déjà 2 mois, la version 0.2.0 de <a href="https://***REMOVED***/login"><b>Galactae: Space Age Rising</b></a> etait dévoliée. Il est maintenant l\'heure de rendre public les changelogs de la nouvelle version 0.3.0 ! Voici donc la liste des nouveautés:</p>
                                                                        <ul>
                                                                            <li>Site Web:<br/>
                                                                                <ul>
                                                                                    <li>Ajout du favicon</li>
                                                                                    <li>Generation automatique de la gallerie selon les images disponibles dans les dossiers.</li>
                                                                                    <li>Amelioration des Conditions generales d\'utilisation</li>
                                                                                    <li>Reecriture des pages l\'equipe, partenaires, devblog, contact, index avec traduction et compatibilité mobile</li>
                                                                                    <li>Le portail du jeu supporte maintenant les sessions par cookies ce qui evite la deconnexion au bout de 30 minutes.</li>
                                                                                    <li>Amelioration des verifications de la page d\'inscription</li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>Securité:<br/>
                                                                                <ul>
                                                                                    <li>Securisation et independance de chaque session de connexion du jeu.</li>
                                                                                    <li>Ajout de la liste des connectés au niveau serveur</li>
                                                                                    <li>Autokick des multiples sessions</li>
                                                                                    <li>Ajout de plusieurs systemes anti-cheat dont un systeme anti usurpation d\'identité</li>
                                                                                    <li>Ajout de commandes pour les moderateurs</li>
                                                                                    <li>Bloquage des MP a soi même</li>
                                                                                    <li>Changement de l\'addresse d\'acces au serveur</li>
                                                                                    <li>Amelioration des logs et de la gestion du serveur</li>
                                                                                    <li>Ajout d\'un systeme de protection antispam</li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>Production et Construction:<br/>
                                                                                <ul>
                                                                                    <li>Calcul de la production energetique au niveau client et serveur</li>
                                                                                    <li>Leger reequilibrage de la production de ressources</li>
                                                                                    <li>Reglage d\'un bug sur l\'ecran de construction de la carriere</li>
                                                                                    <li>Prise en compte de la construction d\'un bâtiment dans la production de ressources</li>
                                                                                    <li>Surproduction des minerais quand les metaux n\'ont plus besoin d\'être produits</li>
                                                                                    <li>Affichage a 0 de la production si les entrepôts sont pleins</li>
                                                                                    <li>Ajouts des calculs de production d\'Helium 3</li>
                                                                                    <li>Ajout des bâtiments spatiaux (images/couts de construction)</li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>Interface utilisateur:<br/>
                                                                                <ul>
                                                                                    <li>Amelioration de certains bugs graphiques dûs aux animations</li>
                                                                                    <li>Nouveau design pour les boutons du chat</li>
                                                                                    <li>Auto-adaptation de la popup de message systeme</li>
                                                                                    <li>Ajout de differents sons a l\'interface utilisateur</li>
                                                                                    <li>Ajout d\'une nouvelle vue pour les planètes (images par Erjiii)</li>
                                                                                    <li>Amelioration du design du panel de construction</li>
                                                                                    <li>Desactivation du bouton de construction si la construction est impossible</li>
                                                                                    <li>Ajout du temps de construction restant</li>
                                                                                    <li>Ajout du decompte avant que les ressources necessaires a une construction soient disponibles</li>
                                                                                    <li>Ajout de nouvelles touches de controle: touches flechées haut et bas pour l\'historique du chat, touches gauche et droite pour changer de planete</li>
                                                                                    <li>Amelioration des de bâtiments terrestres</li>   
                                                                                    <li>Amelioration de l\'ecran de chargement</li>
                                                                                    <li>Amelioration de l\'ecran d\'erreur lors d\'un ecran en mode portrait</li>
                                                                                    <li>Amelioration des traductions</li>
                                                                                    <li>Chat: Ajout du clic gauche sur le pseudo pour mp et clic droit pour ouvrir le profil</li>
                                                                                    <li>Ajout d\'une fleche afin de renseigner si un bâtiment est constructible ou en construction sans aller dans le menu dedié</li>
                                                                                    <li>Le QG est maintenant à la surface de la planete et le reservoir en orbite (meilleur coherence du gameplay)</li>
                                                                                    <li>Ajout de la premiere ebauche d\'interface de gestion des flottes</li>
                                                                                    <li>Modification des barres de defilement afin de respecter la charte graphique</li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>Autre:<br/>
                                                                                <ul>
                                                                                    <li>Resolution d\'un bug de desynchronisation du temps serveur/client.</li>
                                                                                    <li>Resolution d\'un bug lorsqu\'une planete est renommée.</li>
                                                                                    <li>Ajout de la possibilité d\'envoyer des messages privés via <b>@pseudonyme message</b></li>
                                                                                    <li>Ajout des messages systeme dans le chat</li>
                                                                                    <li>Ajout des bonus de connexion quotidiens</li>
                                                                                    <li>Début d\'un systeme de points et de classement dans une galaxie</li>
                                                                                    <li>La planete active est maintenant mémorisée lors d\'une actualisation</li>
                                                                                    <li>Optimisation du code afin de faciliter l\'ajout de nouvelles fonctionnalités et suppression de valeurs "hardcodées".</li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>

                                                                        <p>En cas de problème n\'hesitez pas à nous contacter par mail ! Bon jeu à tous,</p>
                                                                        L\'equipe de dévelopement de Galactae: Space Age Rising<br/>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <!-- separateur horizontal -->
                            <tr>
                                <td width="640" height="20" ></td>
                            </tr>

                            <tr class="content">
                                <td class="w640" class="w640"  width="640">
                                    <table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0">
                                        <tbody>
                                            <tr>
                                                <td  class="w30"  width="30"></td>
                                                <td  class="w580"  width="580"  style="">
                                                    <!-- une zone de contenu -->
                                                    <table class="w580"  width="580" cellpadding="0" cellspacing="0" border="0">
                                                        <tbody>                                                            
                                                            <tr>
                                                                <td class="w580"  width="580">
                                                            <tr>
                                                                <div align="center" class="article-content">
                                                                    <h3><a href="https://***REMOVED***/login" style="color: #00b0ff; text-decoration: none; font-size: 26px;">Jouer maintenant !</a></h3>
                                                                </div>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <!-- separateur horizontal -->
                            <tr>
                                <td width="640" height="20"></td>
                            </tr>

                            <!-- pied de page -->
                            <tr>
                                <td class="w640"  width="640" height="60"></td>
                            </tr>
                            <td align="center" class="w640"  width="640" height="20" style="font-size:13px; color: #dddddd;">Galactae: Space Age Rising - Crée par <a href="https://elanis.eu/">Elanis</a> - Copyright 2016-2017 - Tout droits reservés</td>
                            </tr>
                            <tr>
                                <td class="w640"  width="640" height="10"></td>
                            </tr>
                            <tr>
                            <td align="center" class="w640"  width="640" height="20" style="font-size:12px; color: #dddddd;"> Vous recevez ce mail car vous êtes inscrit à la newsletter de <a href="https://***REMOVED***/blog">Galactae: Space Age Rising</a> si vous souhaitez ne plus recevoir de nouvelles de notre part, veuillez modifier vos preferences dans votre <a href="https://***REMOVED***/profil">profil utilisateur</a>.</td>
                            </tr>
                            <tr>
                                <td class="w640"  width="640" height="10"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>';

	$data = $db->getContent('users',0,1000000,"user_id");

    $dest = array();

	/*foreach ($data as $key => $value) {
        $dest[$value['user_mail']] = $value['user_name'];
    }*/
    $dest["***REMOVED***"] = "elanis";
    $dest["***REMOVED***"] = "elanis2";

    var_dump($dest);

    // Create a message
    $message = Swift_Message::newInstance($msgTitle)
      ->setFrom(array('***REMOVED***' => 'Galactae: Space Age Rising'))
      ->setBcc($dest)
      ->setBody($msg, 'text/html')
      ;

    // Send the message
    $result = $mailer->send($message);
?>
<br/>
NEWSLETTER
<br/>