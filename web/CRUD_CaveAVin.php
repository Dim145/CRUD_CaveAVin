<?php
required_one("AbstractVueRelation");
required_one("FonctionsUtiles.php");
required_one("DataBaseObject.php");

session_start();

function getAcceuil() : String{
    $allFiles = scandir("../Entite"); // En partant du principe que les classes
    // ont le même nom que le fichier dans lequel elle se trouve. (pas sensible a la case)
    echo "<h1>Que voulez vous faire?</h1>";
    echo "<table>";
    foreach ($allFiles as $fichier )
    {
        $fichier = substr($fichier, 0, -4);
        if( str_contains($fichier, "DataBase") || $fichier == "" ) continue;
        echo "<tr>";
        echo "<td>$fichier</td>";
        echo "<td><a href='AffichageTable.php?action=voir&table=$fichier'>Voir</a></td>";
        echo "<td><a href='AffichageTable.php?action=modifier&table=$fichier'>modifer</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo FonctionsUtiles::getFinHTML();
}

$contenu = AbstractVueRelation::getDebutHTML();
$message = "";
// initialisation du connecteur myPDO pour la connexion
// (sans nom de Table à renseigner selon le contexte)
if(isset($_SESSION['myPDO'])){
    $_SESSION['myPDO'] = new MyPDO();
}
$myPDO = $_SESSION['myPDO'];

if (!isset($_GET['action']))
    $_GET['action'] = "initialiser";

switch ($_GET['action']) {
    case 'Initialiser':
        $_SESSION['etat'] = 'Accueil';
        break;
    case 'SelectionnerTable':
        $myPDO->setNomTable($_GET['table']);
        $_SESSION['etat'] = 'afficheTable';
        $_SESSION['table'] = $_GET['table'];
        break;
    case 'SupprimerEntite':
        $myPDO->setNomTable($_SESSION['table']);
        // récupération du nom de colonne dans le GET
        $keyName = array_keys(array_diff_key($_GET, array('action'=>TRUE)))[0];
        $myPDO->delete(array($keyName => $_GET[$keyName]));
        $message .= "<p>Entité ". $_GET[$keyName]." supprimée</p>\n";
        $_SESSION['etat'] = 'afficheTable';
        break;
    case 'CreerEntite': // construction du formulaire de création de l'entité
        $myPDO->setNomTable($_SESSION['table_name']);

        // Réflection pour récupérer la structure de l'entité
        $classeEntite = new ReflectionClass("lmsf\Entite".ucfirst($_SESSION['table_name']));
        $colNames = $classeEntite->getStaticPropertyValue("COLNAMES");
        $colTypes = $classeEntite->getStaticPropertyValue("COLTYPES");
        $paramForm = array_combine($colNames,$colTypes);
        if ($classeEntite->getStaticPropertyValue("AUTOID"))
            $paramForm = array_diff_key($paramForm, array($classeEntite->getStaticPropertyValue(("PK"))[0] => TRUE));
        print_r($paramForm); // $paramForm est un tableau associatif destiné à configurer le formulaire

        // Réflection pour récupérer la bonne vue
        $classeVue = new ReflectionClass("lmsf\Vue" . ucfirst($_SESSION['table_name']));
        $vue = $classeVue->newInstance();
        $contenu .= $vue->getForm4Entity($paramForm, "insérerEntité");

        // valeur par défaut non géré ci-dessus
        //$contenu .= $vue->getForm4Entity(array('liv_num' => array('type' => 'number', 'default' => $nbEntites + 1), 'liv_titre' => 'text', 'liv_depotlegal' => 'date'), "insérerEntité");

        $_SESSION['état'] = 'formulaireTable';
        break;
    case 'ModifierEntite': // construction du formulaire de modification de l'entité
        // ../..
        $_SESSION['état'] = 'formulaireTable';
        break;
    case 'InsererEntite':  // validation du formulaire de création d'une entité
        $myPDO->setNomTable($_SESSION['table_name']);

        // Réflection pour récupérer la structure de l'entité
        $classeEntite = new ReflectionClass("lmsf\Entite".ucfirst($_SESSION['table_name']));
        $colNames = $classeEntite->getStaticPropertyValue("COLNAMES");
        $colTypes = $classeEntite->getStaticPropertyValue("COLTYPES");

        $paramInsert = array_diff_key($_GET, array('action'=>'insérerEntité'));
        if ($classeEntite->getStaticPropertyValue("AUTOID"))
            $paramInsert = array_merge(array($classeEntite->getStaticPropertyValue(("PK"))[0] => null), $paramInsert); // doit respecter l'ordre des cols ???
        print_r($paramInsert);

        $myPDO->insert($paramInsert);
        // avant :  $myPDO->insert(array('liv_num' => $_GET['liv_num'], 'liv_titre' => $_GET['liv_titre'], 'liv_depotlegal' => $_GET['liv_depotlegal']));

        $entite = "?"; //$myPDO->get('liv_num',$_GET['liv_num']);
        $message .= "<p>Entité $entite crée</p>\n";
        $_SESSION['état'] = 'afficheTable';
        break;
    case 'SauverEntite':  // validation  du formulaire de modification de l'entité
        // ../..

        $_SESSION['état'] = 'afficheTable';
        break;
    default:
        $message .= "<p>Action " . $_GET['action'] . " non implémentée.</p>\n";
        $_SESSION['etat'] = 'Accueil';
}

switch ($_SESSION['état']) {
    case 'Accueil':
        $contenu .= getListeTables();
        break;
    case 'AfficheTable' :
        $classeVue = new ReflectionClass("lmsf\Vue".ucfirst($_SESSION['table_name']));
        $vue = $classeVue->newInstance();
        $lesEntites = $myPDO->getAll();
        $contenu .= $vue->getAllEntities($lesEntites);
        break;
    case 'FormulaireTable':
        //rien à faire, tout est fait dans la gestion des Actions ?
        break;
    default:
        $message .= "<p>état ".$_SESSION['etat']." inconnu</p>\n";
        $_SESSION['etat'] = 'Accueil';
}


// ajout d'un lien vers la page d'accueil
$contenu .= "<p><a href='[index.php]?action=Initialiser'>Accueil</a></p>\n";

$contenu .= AbstractVueRelation::getFinHTML();
echo $contenu;
// ../..