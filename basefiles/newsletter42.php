<?php
include_once('./basefiles/header.php');
?>
<?php
	require_once './lib/swiftmailer/lib/swift_required.php';

	// Create the Transport
	$transport = Swift_SmtpTransport::newInstance('***REMOVED***', 465, 'ssl')
	  ->setUsername('***REMOVED***')
	  ->setPassword('***REMOVED***')
	  ;

	// Create the Mailer using your created Transport
	$mailer = Swift_Mailer::newInstance($transport);

	$msg = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Newsletter Galactae: Space Age Rising</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta content="width=device-width">
    <style type="text/css">
    /* Fonts and Content */
    body, td { font-family: "Segoe UI Light","Segoe WPC","Segoe UI", Helvetica, Arial, "Arial Unicode MS", Sans-Serif; }
    body { background-color: #FBFBFA; margin: 0; padding: 0; -webkit-text-size-adjust:none; -ms-text-size-adjust:none; color: #111111; }
    h2{ padding-top:12px; /* ne fonctionnera pas sous Outlook 2007+ */ font-weight: bold; font-size:22px; }
    a { color: #000000; }
    
    @media only screen and (max-width: 480px) { 

        table[class=w275], td[class=w275], img[class=w275] { width:135px !important; }
        table[class=w30], td[class=w30], img[class=w30] { width:10px !important; }  
        table[class=w580], td[class=w580], img[class=w580] { width:280px !important; }
        table[class=w640], td[class=w640], img[class=w640] { width:300px !important; }
        img{ height:auto;}
         /*illisible, on passe donc sur 3 lignes */
        table[class=w180], td[class=w180], img[class=w180] { 
            width:280px !important; 
            display:block;
        }    
        td[class=w20]{ display:none; }    
    } 

    </style>
   
</head>
<body style="margin:0px; padding:0px; -webkit-text-size-adjust:none;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:rgb(42, 55, 78)" >
        <tbody>
            <tr>
                <td align="center" bgcolor="#1D1D1D">
                    <table  cellpadding="0" cellspacing="0" border="0">
                        <tbody>                            
                            <tr>
                                <td class="w640"  width="640" height="10"></td>
                            </tr>

                            <tr>
                                <td align="center" class="w640"  width="640" height="20"> <a style="color:#ffffff; font-size:12px;" href="https://***REMOVED***/blog"><span style="color:#ffffff; font-size:12px;">Voir le contenu de ce mail en ligne</span></a> </td>
                            </tr>
                            <tr>
                                <td class="w640"  width="640" height="10"></td>
                            </tr>


                            <!-- entete -->
                            <tr class="pagetoplogo">
                                <td class="w640"  width="640">
                                    <table  class="w640"  width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#F2F0F0">
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
                                <td class="w640" class="w640"  width="640" bgcolor="#ffffff">
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
                                                                    <div align="left" class="article-content">
                                                                        <p align="center">Bonjour !</p>
                                                                        <p>Elle est là, la tout fraiche mise a jour 0.2.0 de <a href="https://***REMOVED***/login"><b>Galactae: Space Age Rising</b></a> viens d\'être terminée ! Après 2 mois de travail nous sommes fiers de vous la présenter. Concrètement, quelles sont les nouveautées par rapport à la 0.1.0 ?</p>
                                                                        <ul>
                                                                            <li>Interface utilisateur:<br/>
                                                                                <ul>
                                                                                    <li>Amélioration du design reactif ( differentes definitions d\'ecrans )</li>
                                                                                    <li>Ajout des boutons de "volets" afin d\'ouvrir/fermer le chat, le panneau de recherche (mise à jour future), l\'ecran des mouvements (mise à jour future), et la beta de notre carte stellaire.</li>
                                                                                    <li>Resolution de multiples bugs sur l\'affichage du chat.</li>
                                                                                    <li>Simplification du panneau d\'amelioration des bâtiments.</li>
                                                                                    <li>Ajout du menu afin de se déconnecter et d\'acceder aux differents paramètres (mise à jour future)</li>
                                                                                    <li>Ajout de la possibilité de choisir le nom de sa planète.</li>
                                                                                    <li>Harmonisation du design général</li>
                                                                                    <li>Ajout des informations supplementaires lors du survol d\'une ressource</li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>Algorithmes géneraux:<br/>
                                                                                <ul>
                                                                                    <li>Production des differentes ressources.</li>
                                                                                    <li>Production des ressources selon le bâtiment en cours de construction</li>
                                                                                    <li>Limitation du stockage</li>
                                                                                    <li>Refonte du système énergetique</li>
                                                                                    <li>Nouveaux calculs pour l\'amelioration de bâtiments</li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>Gameplay:<br/>
                                                                                <ul>
                                                                                    <li>Ajout du choix de type de gouvernement</li>
                                                                                    <li>Séparation des comptes de chaque utilisateur ainsi que de chaque planète.</li>
                                                                                </ul>
                                                                            </li>
                                                                            <li>Autre:<br/>
                                                                                <ul>
                                                                                    <li>Nombreuses sécurité au niveau client et serveur.</li>
                                                                                    <li>Systeme anti-cheat amélioré</li>
                                                                                    <li>Affichage des Staff et Admin dans le chat</li>
                                                                                    <li>Ajout de certains raccourci clavier selon les fenetres</li>
                                                                                    <li>Les calculs serveurs ainsi que les echanges avec le client sont allegés</li>
                                                                                    <li>Sécurisation des transferts d\'informations client/serveur.</li>
                                                                                    <li>Mise à disposition d\'un serveur de chat vocal (Discord).</li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>

                                                                        <p>Nous esperons que vous apprecierez cette mise et vous souhaitons un bon jeu ! En cas de problème n\'hesitez pas à contacter le support du jeu.</p>
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
                                <td width="640" height="20" bgcolor="#ffffff"></td>
                            </tr>

                            <tr class="content">
                                <td class="w640" class="w640"  width="640" bgcolor="#ffffff">
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
                                                            <tr>
                                                                <div align="center" class="article-content">
                                                                    <h3><a id="playbutton" href="https://***REMOVED***/login" style="color: black; font-weight: bold; text-decoration: none;">Jouer maintenant !</a></h3>
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
                                <td width="640" height="20" bgcolor="#ffffff"></td>
                            </tr>

                            <!-- pied de page -->
                            <tr class="pagebottom">
                                <td class="w640"  width="640">
                                    <table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#c7c7c7">
                                        <tbody>
                                            <tr>
                                                <td colspan="5" height="10"></td>
                                            </tr>
                                            <tr>
                                                <td class="w30"  width="30"></td>
                                                <td class="w580"  width="580" valign="top">
                                                    <p align="center" class="pagebottom-content-left">
                                                        Galactae: Space Age Rising - Crée par <a href="https://elanistudio.eu/">Elanis</a><br/>
                                                        <br/>
                                                        Copyright 2016-2017 - Tout droits reservés
                                                    </p>
                                                </td>

                                                <td class="w30"  width="30"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" height="10"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="w640"  width="640" height="60"></td>
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

	foreach ($data as $key => $value) {
        $dest[$value['user_mail']] = $value['user_name'];
    }

    // Create a message
    $message = Swift_Message::newInstance("La mise à jour 0.2.0 est desormais disponible !")
      ->setFrom(array('***REMOVED***' => 'Galactae: Space Age Rising'))
      ->setBcc($dest)
      ->setBody($msg, 'text/html')
      ;

    // Send the message
    $result = $mailer->send($message);
?>