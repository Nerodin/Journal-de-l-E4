<?php
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Symfony\Component\Yaml\Yaml;

class ExchangeRun extends Command
{
  private $logger;
  /**
  * constructeur pour les logs
  *
  * @param LoggerInterface $logger Initialisation du logger avec la configuration par défaut
  *
  */
  public function __construct(LoggerInterface $logger) {
      $this->logger = $logger;
      parent::__construct();
  }

//fonction qui va recupérer l'argument mis apres la command
  protected function configure() {
    $this
    // configure an argument
    ->addArgument('client', InputArgument::REQUIRED, 'The client of the user.')

    // the name of the command (the part after "bin/console")
    ->setName('exchange-sync:run')

    // the short description shown while running "php bin/console list"
    ->setDescription('show text in one file.')

    // the full command description shown when running the command with
    // the "--help" option
    ->setHelp('This command allows you to deplace file & directory...')

    ;
  }

  /**
  * permet d'éxecuter la command php bin/console exchange-sync:run [nom du client]
  *
  * @param object $client
  * @param object $output
  *
  */
    public function execute(InputInterface $client, OutputInterface $output) {

      // Récupération du client
      // TODO controle si non renseigné
      $client = $client->getArgument('client');

      // Chemin du fichier de configuation de l'application
      // TODO controle si le fichier n'existe pas
      $filename = getcwd()."/exchange-sync.yml";

      //Chargement du fichier de configuraton
      $generalConf = Yaml::parse(file_get_contents($filename), Yaml::PARSE_EXCEPTION_ON_INVALID_TYPE);

      // Initialisation des logs
      $logfile = $generalConf['logfile'];
      $this->logger->pushHandler(new StreamHandler($logfile));
      $this->logger->info("------------------------------------------------");
      $this->logger->info("Début de la séquence : $client");

      //regarde si le fichier de configuration client existe
      if (file_exists($generalConf['exchangesdir'].$client.'.yml')) {

        $confClientPath =  $generalConf['exchangesdir'].$client;
        $this->logger->info("Le fichier de configuration $client existe");

        $confClient = Yaml::parse(file_get_contents($confClientPath.'.yml'), Yaml::PARSE_EXCEPTION_ON_INVALID_TYPE);
        $clientOpt = $this->getClientOpt($confClientPath,$generalConf);

        $this->logger->info("Cas EXCHANGE");

        $this->logger->info("Enter in who Execute for this conf : ");
        foreach($confClient['exchanges'] as $conf) {
          foreach($conf as $key => $path) {
            if ($key == "from" && substr($path , 0, 3) == "ftp") {
              echo "Ftp to Local : ";
              print_r($conf);
              echo "\n";
              // $this->executeFtptoLocal();
            }
            elseif ($key == "to" && substr($path , 0, 3) == "ftp") {
              echo "local to ftp : ";
              print_r($conf);
              echo "\n";
              // $this->executeLocalToFtp($confClient,$client,$clientOpt,$conf);
            }
            elseif ($key == "to" && substr($path , 0, 1) == "/") {
              echo "Exchanges : ";
              print_r($conf);
              echo "\n";
              // $this->ExecuteExchanges( $conf,$client,$clientOpt);
            }
          }
        }
      }
      else {
        // retrieve the argument value using getArgument()
        $this->logger->info("Erreur d'accès au fichier client: $client");
        $output->writeln("Le fichier n'existe pas : faire exchange-sync:listfile pour pouvoir afficher les fichiers disponibles");
      }
    }

/**
* recupere le nom du client mis dans la commande et aussi les options du fichier de conf du client en question
*
* @param array $generalConf
* @param string $confClientPath
*
* @return array
*/
  private function getClientOpt($confClientPath,$generalConf) {
    $this->logger->info("Enter in getClientOpt");

    $fichier = Yaml::parse(file_get_contents($confClientPath.".yml"));

    if (!empty($fichier['opt'])) {

      $valueOpt = $fichier['opt'];

      $LogLevel = $valueOpt['LogLevel'];
      $LogFile = $valueOpt['LogFile'];
      $FolderActive = $valueOpt['FolderActive'];

      //FolderActive
      if (empty($FolderActive)) {
        $FolderActive = $generalConf['FolderActive'];
      }
      else {
        $FolderActive = $valueOpt['FolderActive'];
      }
      //LogFile
      if (empty($LogFile)) {
        $LogFile = '%Kernel.project_dir%/var/logs/exchange-sync.log' ;
      }
      else {
        $LgoFile = $valueOpt['LogFile'];
      }
      //LogLevel
      if (empty($LogLevel)) {
        $LogLevel = $generalConf['loglevel'];
      }
      else {
        $LogLevel = $valueOpt['LogLevel'];
      }
      return ['LogLevel' => $LogLevel, 'LogFile' => $LogFile , 'FolderActive' => $FolderActive];
    }
    else {
      $LogLevel = $generalConf['loglevel'];
      return ['LogLevel' => $LogLevel , 'LogFile' => $LogFile , 'FolderActive' => $FolderActive];
    }
  }

/**
* Execution des options exchange
* TODO faire un return si OK ou KO
*
* @param array $AppconfigElement
* @param array $confClient
* @param string $client
* @param array $generalConf
*
*/
  private  function executeExchanges( $conf,$client,$clientOpt){
    $this->logger->info('Enter in ExecuteExchange',$clientOpt);

    foreach ($conf as $key => $path) {
      if (!is_dir($path)) {

        $back = "backup";
        $dateActuelle = date("Y/m/j") ;
        $dossiers = ("/shares/".$back.DIRECTORY_SEPARATOR.$client.DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$dateActuelle); // /shares/backup/aref/ext/fact_adb
        if (!is_dir($dossiers)) {
          mkdir($dossiers ,0777, true);
          $this->logger->info('Création du fichier backup du jour : '.$dateActuelle.' pour le client : '. $client);
        }
        else {
          if (!file_exists(!is_dir($dossiers))) {
            $this->logger->info("Le fichier du jour : $dateActuelle est deja crée sur le client : $client");
          }
          else {
            $this->logger->info("Attention il y a un probleme sur la creation du fichier du jour sur le client : $client ");
          }
        }
      }
      else {
        $shares = $path ;
      }
    }
    $pathFrom = $conf['from'] ;
    $this->logger->info('transfert des fichiers : '.$pathFrom.' vers les dossiers '.$shares);
    if (is_dir($pathFrom)) {
      // si le pathFrom existe deja il ne fait rien sinon il le crée
    }
    else {
      mkdir($pathFrom,0755,true);
    }

    $filesFrom = (scandir($pathFrom));
    $filesTo = (scandir($shares));
    unset($filesFrom[0]);
    unset($filesFrom[1]);
    unset($filesTo[0]);
    unset($filesTo[1]);

    if ($clientOpt['FolderActive'] == true) {
      //copie les fichiers et les repertoires avec toute l'arbo derriere
      foreach ($filesFrom as $fileFrom) {
        if (file_exists($pathFrom) && !is_dir($pathFrom.DIRECTORY_SEPARATOR.$fileFrom)) {
          copy($pathFrom.DIRECTORY_SEPARATOR.$fileFrom,$shares.DIRECTORY_SEPARATOR.$fileFrom);
          $this->logger->info("Transfere du ".$pathFrom." vers le ".$shares);
          copy($pathFrom.DIRECTORY_SEPARATOR.$fileFrom,$dossiers.DIRECTORY_SEPARATOR.$fileFrom);
          $this->logger->info("Transfere du ".$pathFrom." vers le ".$dossiers);
          unlink($pathFrom.DIRECTORY_SEPARATOR.$fileFrom);

          $this->logger->info("transfert des fichiers reussi : $client");
        }
      }
      // $this->logger->info('=============');
      if (!empty($filesFrom)) {
        $this->logger->info('Copie des fichiers :');
        $dir2copy = $pathFrom.DIRECTORY_SEPARATOR.$fileFrom ;
        $dir_paste = $shares.DIRECTORY_SEPARATOR.$fileFrom ;
        $backup_paste = $dossiers.DIRECTORY_SEPARATOR.$fileFrom ;

        $this->copy_Dir($dir2copy,$dir_paste,$backup_paste);

        $this->logger->info("copie des repertoires et sous repertoires et fichiers dans le client : $client");
        $this->logger->info("suppresion des repertoires et sous repertoires et fichiers dans le client : $client");
      }
    }
    //si FolderActive est à false fait :
    else {
      // copie juste les fichiers prèsent dans le fichier de conf
      foreach ($filesFrom as $fileFrom) {
        //VERIFIE SI LE FICHIER EXISTE ET SI C PAS UN DOSSIER ET DONC SI LES DEUX SONT OK SA COPY SUR TO ET BACKUP_DIR PUIS SA SUPPRIME DU FROM
        if (file_exists($pathFrom) && !is_dir($pathFrom.DIRECTORY_SEPARATOR.$fileFrom)) {
          copy($pathFrom.DIRECTORY_SEPARATOR.$fileFrom,$shares.DIRECTORY_SEPARATOR.$fileFrom);
          copy($pathFrom.DIRECTORY_SEPARATOR.$fileFrom,$dossiers.DIRECTORY_SEPARATOR.$fileFrom);
          unlink($pathFrom.DIRECTORY_SEPARATOR.$fileFrom);

          $this->logger->info("transfert des fichiers reussi : $client");
        }
        else {
          $this->logger->info("Il n'y a plus de fichier a déplacé ou il y a un dossier dans le repertoire : $client");
        }
      }
    }
  }
  /**
  * fonction pour ouvrir la connextion ftp
  *
  * @param array $AppconfigElement
  *
  */
  private  function executeLocalToFtp($confClient,$client,$clientOpt,$conf) {
    $confFTP = $confClient['ftp'];
    $this->logger->info("executeLocalToFtp",$confFTP );

    foreach ($conf as $key => $path) {
      if (!is_dir($path)) {

        $back = "backup";
        $dateActuelle = date("Y/m/j") ;
        $dossiers = ("/shares/".$back.DIRECTORY_SEPARATOR.$client.DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$dateActuelle); // /shares/backup/aref/ext/fact_adb
        if (!is_dir($dossiers)) {
          mkdir($dossiers ,0777, true);
          $this->logger->info('Création du fichier backup du jour : '.$dateActuelle.' pour le client : '. $client);
        }
      }
      else {
        $shares = $path ;
      }
    }
    $pathFrom = $conf['from'] ;
    $this->logger->info('transfert des fichiers : '.$pathFrom.' vers les dossiers '.$shares);
    if (is_dir($pathFrom)) {
      // si le pathFrom existe deja il ne fait rien sinon il le crée
      $this->logger->info("pathFrom deja créer");
    }
    else {
      mkdir($pathFrom,0755,true);
    }

    $filesFrom = (scandir($pathFrom));
    $filesTo = (scandir($shares));
    unset($filesFrom[0]);
    unset($filesFrom[1]);
    unset($filesTo[0]);
    unset($filesTo[1]);

    $connection = $this->connectFtp($confClient,$client);
//deuxieme verification pour etre sure que la connection est maintenue
    if ($connection == false) {
      $this->logger->warning("PROBLEM A BEEN DETECTED ! prostagma");die();
    }
//ici on est connecté (ressource ID)
    if ($clientOpt['FolderActive'] == true) {
//je copie d'abord les fichiers du local vers le ftp
      foreach ($filesFrom as $fileFrom) {
        if (file_exists($pathFrom) && !is_dir($pathFrom.DIRECTORY_SEPARATOR.$fileFrom)) {
          $upload = ftp_put($connection,$fileFrom,$pathFrom .DIRECTORY_SEPARATOR. $fileFrom, FTP_BINARY);
          if (!$upload) {
            $this->logger->info("FTP upload has failed!");
          }
          else {
            $this->logger->info("FTP succes ");
          }
        }
      }
//puis je regarde si il y a un ou plusieurs dossiers et donc je le transfert
      foreach ($filesFrom as $fileFrom) {
        //VERIFIE SI LE FICHIER EXISTE ET SI C PAS UN DOSSIER ET DONC SI LES DEUX SONT OK SA COPY SUR TO ET BACKUP_DIR PUIS SA SUPPRIME DU FROM
        if (file_exists($pathFrom) && !is_dir($pathFrom.DIRECTORY_SEPARATOR.$fileFrom)) {
          copy($pathFrom.DIRECTORY_SEPARATOR.$fileFrom,$dossiers.DIRECTORY_SEPARATOR.$fileFrom);
        }
      }
      if (!empty($fileFrom)) {
        $dir2copy = $pathFrom.DIRECTORY_SEPARATOR.$fileFrom ;
        $dir_paste = "/home/test/".$fileFrom;
        $this->localtoftp_copy($connection,$dir2copy,$dir_paste,$fileFrom);

        if (!empty($dir2copy)) {
          $this->executeLocalToFtp($confClient,$client,$clientOpt,$conf);
        }
      }
    }
    else {

      // copie juste les fichiers prèsent dans le fichier de conf
      foreach ($filesFrom as $fileFrom) {
        //VERIFIE SI LE FICHIER EXISTE ET SI C PAS UN DOSSIER ET DONC SI LES DEUX SONT OK SA COPY SUR TO ET BACKUP_DIR PUIS SA SUPPRIME DU FROM
        if (file_exists($pathFrom) && !is_dir($pathFrom.DIRECTORY_SEPARATOR.$fileFrom))  {
          $upload = ftp_put($connection, $fileFrom, $fileFrom, FTP_BINARY);
          if (!$upload) {
            $this->logger->info("FTP upload has failed!");
          }
          else {
            $this->logger->info("FTP succes ");
          }
        }
        else {

        }
      }
    }
  }

/**
* @param string D
*/
  private function localtoftp() {

  }


// TODO Creer un objet qui donne la connection
/**
* fonction pour ouvrir la connextion ftp
*
* @param array $AppconfigElement
* @param array $confClient
* @param string $client
* @param string $connectionOpt
*
*/
  private function connectFtp($confClient,$client) {
    $this->logger->info('Entrée dans connectFtp');
    $conf_FTP = $confClient['ftp'];

    $connectionOpt = $conf_FTP[0]['name'];
    $user = $conf_FTP[0]['user'];
    $host = $conf_FTP[0]['host'];
    $port = $conf_FTP[0]['port'];
    $passLTF = $conf_FTP[0]['password'];

    $this->logger->info('conf FTP :',[
      'name' => $connectionOpt,
      'user' => $user,
      'host' => $host,
      'port' => $port,
      'password' => $passLTF,
    ]);

    $password = $passLTF;
    $connection_server = $host;
    $connection_user_name = $user;
    $connection_user_pass = $passLTF;
    $connection_port = $port;

    $connection = ftp_connect($connection_server,$connection_port);

    if (@ftp_login($connection, $connection_user_name, $connection_user_pass)) {
        $this->logger->info("Connecté en tant que $connection_user_name");
        return $connection;
    } else {
        $this->logger->info("Connexion impossible en tant que $connection_user_name");
    }
  }

/**
* fonction qui va éxecuter la fonction principale tout en s'adaptant a l'option de transfert
*
* @param string $AppconfigElement
* @param array $confClient
* @param string $client
* @param resource $connection
*
*/
  private function main_body($AppconfigElement, $confClient,$client,$connectionOpt,$connection = "",$host = "",$user = "",$password = "",$port = "") {
    // $options = $this->getClientOpt($generalConf,$client);
    // $this->logger->pushHandler(new StreamHandler(getcwd().$options['LogFile']));
    //
    // $LogLevel = $options["LogLevel"];
    // $FolderActive = $options["FolderActive"];
    $this->logger->info('Entrée dans main_body');

    foreach ($confClient as $yamlArg) {
      $this->logger->info("arg ", ['arg' => $yamlArg]);
      foreach ($yamlArg as $key => $path) {
        $this->logger->info("k&v ", ['key' => $key , 'path' => $path]);
        if (!is_dir($path)) {
          $back = explode(",",$AppconfigElement);
          $this->logger->info("back ", ['back' => $back]);
          $dateActuelle = date("Y/m/j") ;
          $dossiers = ($back[0].DIRECTORY_SEPARATOR.$client.DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$dateActuelle);

          if (!is_dir($dossiers)) {
            $this->logger->info("Création du fichier backup_dir/du jour : $dossiers");
            mkdir($dossiers ,0777, true);
          }
          else {
            if (!file_exists(!is_dir($dossiers))) {
              // $this->logger->info("Le fichier du jour : $dateActuelle est deja crée sur le client : $client");
            }
            else {
              $this->logger->warning("Attention il y a un probleme sur la creation du fichier du jour sur le client : $client ");
            }
          }
        }
        else {
          // $shares = $path ;
        }
      }
      echo "path : $path";

      //RECUPERE LES TO plus la valeur de chacun
      $to = ($back[2]." : ".$path."\n");
      $pathTo = $path ;

      //RECUPERE LES FROM plus la valeur de chacun
      $from = ($back[1]." : ".$yamlArg['from']."\n");
      $pathFrom = $yamlArg['from'] ;

      //ENLEVE LES . ET .. DE CHAQUE REPERTOIRE POUR N'AVOIR QUE LES FICHIERS
      $filesFrom = (scandir($pathFrom));
      $filesTo = (scandir($pathTo));
      unset($filesFrom[0]);
      unset($filesFrom[1]);
      unset($filesTo[0]);
      unset($filesTo[1]);

      switch ($connectionOpt) {
        case 'localtolocal':
        echo "rentre dans le localtolocal\n";
        if ($FolderActive == 1) {
              //copie les fichiers et les repertoires avec toute l'arbo derriere
            foreach ($filesFrom as $fileFrom) {
              if (file_exists($pathFrom) && !is_dir($pathFrom.DIRECTORY_SEPARATOR.$fileFrom)) {
                 copy($pathFrom.DIRECTORY_SEPARATOR.$fileFrom,$pathTo.DIRECTORY_SEPARATOR.$fileFrom);
                // echo("Transfere du ".$pathFrom." vers le ".$pathTo." \n");
                copy($pathFrom.DIRECTORY_SEPARATOR.$fileFrom,$dossiers.DIRECTORY_SEPARATOR.$fileFrom);
                     // echo("Transfere du ".$pathFrom." vers le ".$dossiers." \n");
                unlink($pathFrom.DIRECTORY_SEPARATOR.$fileFrom);
                // echo("Supresion du ".$pathFrom." \n");
                 echo("fini \n");
              }
            }
              if (!empty($fileFrom)) {
            $dir2copy = $pathFrom.DIRECTORY_SEPARATOR.$fileFrom ;
            $dir_paste = $pathTo.DIRECTORY_SEPARATOR.$fileFrom ;

            $this->copy_Dir($dir2copy,$dir_paste);

          }
        }
        //si FolderActive est à false fait :
        else {
          // copie juste les fichiers prèsent dans le fichier de conf
          foreach ($filesFrom as $fileFrom) {
            //VERIFIE SI LE FICHIER EXISTE ET SI C PAS UN DOSSIER ET DONC SI LES DEUX SONT OK SA COPY SUR TO ET BACKUP_DIR PUIS SA SUPPRIME DU FROM
            if (file_exists($pathFrom) && !is_dir($pathFrom.DIRECTORY_SEPARATOR.$fileFrom)) {
              copy($pathFrom.DIRECTORY_SEPARATOR.$fileFrom,$pathTo.DIRECTORY_SEPARATOR.$fileFrom);
              // echo("Transfere du ".$pathFrom." vers le ".$pathTo." \n");
              copy($pathFrom.DIRECTORY_SEPARATOR.$fileFrom,$dossiers.DIRECTORY_SEPARATOR.$fileFrom);
              // echo("Transfere du ".$pathFrom." vers le ".$dossiers." \n");
              unlink($pathFrom.DIRECTORY_SEPARATOR.$fileFrom);
              // echo("Supresion du ".$pathFrom." \n");
              echo("fini \n");

            }
            else {

            }
          }
        }
        break;
        case 'localtoftp':
          echo "rentre dans le localtoftp\n";

          if ($FolderActive == 1) {
            //copie les fichiers et les repertoires avec toute l'arbo derriere
            echo "string\n";
            print_r($filesFrom);
            foreach ($filesFrom as $fileFrom) {
              echo "HELLOOOOOO";
              print_r($pathFrom);

              if (file_exists($pathFrom) && !is_dir($pathFrom.DIRECTORY_SEPARATOR.$fileFrom)) {
                $upload = ftp_put($connection,$fileFrom,$pathFrom .DIRECTORY_SEPARATOR. $fileFrom, FTP_BINARY);
                if (!$upload) {
                  echo "FTP upload has failed! \n";
                }
                else {
                  echo "FTP succes \n";
                }
                echo("fini \n");//A

              }
            }
            foreach ($filesFrom as $fileFrom) {
              //VERIFIE SI LE FICHIER EXISTE ET SI C PAS UN DOSSIER ET DONC SI LES DEUX SONT OK SA COPY SUR TO ET BACKUP_DIR PUIS SA SUPPRIME DU FROM
              if (file_exists($pathFrom) && !is_dir($pathFrom.DIRECTORY_SEPARATOR.$fileFrom)) {
                copy($pathFrom.DIRECTORY_SEPARATOR.$fileFrom,$dossiers.DIRECTORY_SEPARATOR.$fileFrom);
                echo("fini de copier sur le backup \n");
              }
            }
            if (!empty($fileFrom)) {
              echo "-------------------------\n";
              print_r($fileFrom."\n");
              echo "-------------------------\n";

              $dir2copy = $pathFrom.DIRECTORY_SEPARATOR.$fileFrom ;
              $dir_paste = "/home/test/".$fileFrom;

              echo"========== \n";
              print_r($dir_paste."\n");
              echo"========== \n";

              echo "COPY \n";
                      $this->localtoftp_copy($connection,$dir2copy,$dir_paste,$fileFrom);
              echo "COPYDIR \n";

              if (!empty($dir2copy)) {
                $this->main_body($AppconfigElement, $confClient,$client,$connectionOpt,$connection);
              }


            }
          }
        //si FolderActive est à false fait :
        else {
          // copie juste les fichiers prèsent dans le fichier de conf
          foreach ($filesFrom as $fileFrom) {
            echo "COUCOUCOUCOUCOUC";
            //VERIFIE SI LE FICHIER EXISTE ET SI C PAS UN DOSSIER ET DONC SI LES DEUX SONT OK SA COPY SUR TO ET BACKUP_DIR PUIS SA SUPPRIME DU FROM
            if (file_exists($pathFrom) && !is_dir($pathFrom.DIRECTORY_SEPARATOR.$fileFrom))  {
              $upload = ftp_put($connection, $fileFrom, $fileFrom, FTP_BINARY);
              if (!$upload) {
                echo "FTP upload has failed! \n";
              }
              else {
                echo "FTP succes \n";
              }
              echo("fini \n");

            }
            else {

            }
          }
        }

        break;
        case 'ftptolocal':
          echo "rentre dans le ftptolocal\n";

          $path = "/home/test/";

          $dir2copy = $pathFrom ;
          $dir_paste = "/home/test/";

//juste pour voir les fichier dans le ftp ( du coup tu print sa et sa t'afficher dossier et fichier )
          $filesFromFtp = $this->scandir($host,$user,$password,$path,$port = 21);

          $local_dir = $dir2copy;
          $remote_dir = $dir_paste;
          if ($FolderActive == 1) {
            $this->download_all($connection,$remote_dir,$local_dir);
          }
          else {

          }
        break;
        default:
          echo "$connectionOpt \n";
      }
    }
  }

//================================================================================================================================================================================//
//N                                                                                                                                                                                //
//                                                                                                                                                                                //
//                                                                                                                                                                                //
//                                                                                                                                                                                //
//                                                                                                                                                                                //
//================================================================================================================================================================================//

/**
* fonction pour ouvrir la connextion ftp
*
* @param string $dir2copy
*
*/
  public function delTree($dir2copy) {
    if (is_dir($dir2copy)) {
      $files = array_diff(scandir($dir2copy), array('.','..'));
      foreach ($files as $file) {
          (is_dir("$dir2copy/$file")) ? delTree("$dir2copy/$file") : unlink("$dir2copy/$file");
      }
      return rmdir($dir2copy);
    }
    else {
      unlink($dir2copy);
    }
  }

/**
* fonction pour ouvrir la connextion ftp
*
* @param string $dir2copy
* @param string $dir_paste
*
*/
  private function copy_Dir($dir2copy,$dir_paste,$backup_paste) {
    $this->logger->info('Rentre dans le CopyDir');
    // On vérifie si $dir2copy est un dossier
    if (is_dir($dir2copy)) {
      // Si oui, on l'ouvre
      if ($dh = opendir($dir2copy)) {
        // On liste les dossiers et fichiers de $dir2copy
        while (($file = readdir($dh)) !== false ) {
          // Si le dossier dans lequel on veut coller n'existe pas, on le créé
          if (!is_dir($dir_paste)) {
            mkdir ($dir_paste, 0777);
          }
          if (!is_dir($backup_paste)) {
            mkdir ($backup_paste, 0777);
          }
          // S'il s'agit d'un dossier, on relance la fonction récursive
          if(is_dir($dir2copy.DIRECTORY_SEPARATOR.$file) && $file != '..'  && $file != '.') {
            $this->copy_Dir( $dir2copy.DIRECTORY_SEPARATOR.$file.DIRECTORY_SEPARATOR , $dir_paste.DIRECTORY_SEPARATOR.$file.DIRECTORY_SEPARATOR, $backup_paste.DIRECTORY_SEPARATOR.$file );
          }//G
          elseif($file != '..'  && $file != '.') {
            copy($dir2copy.DIRECTORY_SEPARATOR.$file,$dir_paste.DIRECTORY_SEPARATOR.$file);
            copy($dir2copy.DIRECTORY_SEPARATOR.$file,$backup_paste.DIRECTORY_SEPARATOR.$file);
            $this->logger->info("fini".$dir2copy.DIRECTORY_SEPARATOR.$file);
          }
        }
        //commande poour suppr le repertoire et ces fichiers
        $this->delTree($dir2copy);
        // On ferme $dir2copy
        closedir($dh);
      }
    }
  }

/**
* fonction pour ouvrir la connextion ftp
*
* @param string $dir_paste
*
* @param resource $connection
*
*/
  function make_directory($connection, $dir_paste) {
    if ($this->ftp_is_dir($connection, $dir_paste) || @ftp_mkdir($connection, $dir_paste)) return true;
      if (!$this->make_directory($connection, dirname($dir_paste))) return false;
        return ftp_mkdir($connection, $dir_paste);
  }

/**
* fonction pour ouvrir la connextion ftp
*
* @param string $dir_paste
*
* @param resource $connection
*
*/
  function ftp_is_dir($connection, $dir_paste) {
    // get current directory
    $original_directory = ftp_pwd($connection);
    if ( @ftp_chdir( $connection, $dir_paste ) ) {
      // If it is a directory, then change the directory back to the original directory
      ftp_chdir( $connection, $original_directory );
      return true;
    }
    else {//E
      return false;
    }
  }

/**
* fonction pour ouvrir la connextion ftp
*
* @param string $dir_paste
* @param string $fileFrom
*
* @param resource $connection
*
*/
  function localtoftp_copy($connection, $dir2copy, $dir_paste,$fileFrom) {
    if (is_dir($dir2copy)) {
      if ($dh = opendir($dir2copy)) {
        while (($file = readdir($dh)) !== false ) {
          // Si le dossier dans lequel on veut coller n'existe pas, on le créé
          if (!is_dir($dir_paste)){
            $this->make_directory($connection, $dir_paste);
          }
          // S'il s'agit d'un dossier, on relance la fonction récursive
          if(is_dir($dir2copy.DIRECTORY_SEPARATOR.$file) && $file != '..'  && $file != '.') {
            $this->localtoftp_copy($connection , $dir2copy.DIRECTORY_SEPARATOR.$file.DIRECTORY_SEPARATOR , $dir_paste.DIRECTORY_SEPARATOR.$file.DIRECTORY_SEPARATOR,$fileFrom);
          }
          elseif($file != '..'  && $file != '.') {
            ftp_nb_put($connection, $dir_paste.DIRECTORY_SEPARATOR.$file, $dir2copy.DIRECTORY_SEPARATOR.$file, FTP_BINARY);
            $this->logger->info("fini de transferer le fichier/dossier : ".$dir2copy.DIRECTORY_SEPARATOR.$file);
          }
        }
        $this->delTree($dir2copy);
        closedir($dh);
      }
    }
    else {
      if(file_exists($dir2copy)){
        if(!is_dir($dir2copy)) {
          $this->delTree($dir2copy);
        }
      }
    }
  }

/**
* fonction pour ouvrir la connextion ftp
*
* @param string $host
* @param string $user
* @param string $password
* @param string $port
*
*/
  private function login($host, $user, $password, $port = 21) {
    $connection = false;
    try {
      $connection = ftp_connect($host, $port);
      // $connection = ftp_ssl_connect($host);
      if($connection!==false) {
        # Login into FTP server
        if(ftp_login($connection, $user, $password)) {
          # Set the network timeout to 10 seconds
          ftp_set_option($connection, FTP_TIMEOUT_SEC, 3000);
        }
        else {
          $connection = false;
          error_log("Ftp::login : cannot connect as $user");
        }
      }
    }
    catch(Exception $e) {
      error_log("Ftp::login : " . $e->getMessage());
    }
    return $connection;
  }

/**
* fonction pour ouvrir la connextion ftp
*
* @param string $host
* @param string $user
* @param string $password
* @param string $path
* @param string $port
*
*///R
  public function scandir($host, $user, $password, $path, $port = 21) {
    $files = false;
    if(false !== $connection = exchangerun::login($host, $user, $password, $port)) {
      $files = ftp_nlist($connection, $path);
      ftp_close($connection);
    }
    return $files;
  }

/**
* fonction pour ouvrir la connextion ftp
*
* @param string $dir
*
* @param resource $connection
*
*/
  private function is_dir($dir, $connection) {
    $is_dir = false;
    # Get the current working directory
    $origin = ftp_pwd($connection);
    # Attempt to change directory, suppress errors
    if (@ftp_chdir($connection, $dir)) {
      # If the directory exists, set back to origin
      ftp_chdir($connection, $origin);
      $is_dir = true;
    }
    return $is_dir;
  }

/**
* Recursive function to download remote files
*
* @param resource $connection
* @param string $remote_dir
* @param string $local_dir
*
* @return bool $download_all
*
*/
  private function download_all($connection, $remote_dir, $local_dir) {

    $files = ftp_nlist($connection, $remote_dir);
    foreach ($files as $file) {
      print_r($file."\n");
    }
    $download_all = false;
    try {
      echo "$remote_dir\n";
      if(exchangerun::is_dir($remote_dir, $connection)) {
        $files = ftp_nlist($connection, $remote_dir);
        if($files!==false) {
          $to_download = 0;
          $downloaded = 0;
          # do this for each file in the remote directory
          foreach ($files as $file) {
            echo "$file\n";
            # To prevent an infinite loop
            if ($file != "." && $file != "..") {
            // if(is_dir($file) && $file != '..'  && $file != '.') {
              $to_download++;
              # do the following if it is a directory
              if (exchangerun::is_dir($file, $connection)) {
                # Create directory on local filesystem
                echo "$local_dir , =====================> \n";
                if(file_exists($local_dir. DIRECTORY_SEPARATOR .basename($file))) {
                  print_r($remote_dir."\n");
                  $this->delTreeFtp($remote_dir,$connection);
                  die();
                }
                mkdir($local_dir . DIRECTORY_SEPARATOR . basename($file));
                # Recursive part

                if(exchangerun::download_all($connection, $file, $local_dir . DIRECTORY_SEPARATOR . basename($file))) {
                  $downloaded++;
                }
              }
              else {
                # Download files
                if(ftp_get($connection, $local_dir . DIRECTORY_SEPARATOR . basename($file), $file, FTP_BINARY)) {
                  $downloaded++;
                }
              }
            }
          }
          # Check all files and folders have been downloaded
          if($to_download===$downloaded) {
            $download_all = true;
          }
        }
      }
    }
    catch(Exception $e) {
      error_log("Ftp::download_all : " . $e->getMessage());
    }
    return $download_all;
  }

/**
* Recursive function to download remote files
*
* @param resource $connection
*
* @param string $remote_dir
*
*/
  public function delTreeFtp($remote_dir,$connection) {
    if (is_dir($remote_dir)) {
      $path = "/home/test/";
      $files = array_diff(ftp_nlist($connection, $path),array('.','..'));
      print_r($files);
      foreach ($files as $file) {
        print($file);die();
        (is_dir("$file")) ? $this->delTreeFtp("$file",$connection) : ftp_delete($connection,"$file");
        echo "SUPPRESION \n";
      }
      return ftp_rmdir($connection,$remote_dir);
    }
    else {
      if(ftp_delete($connection, $file)){
        echo "$file deleted successful";
      } else {
        echo "There was an error while deleting $file";
      }
      echo "SUPPRESION \n";
    }
  }
}
?>
