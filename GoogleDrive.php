<?php

	class GoogleDrive 
	{
	    private $pathJSON; 
		private $nombreCarpeta;

		private $word;
		private $excel;
		private $mapa;
		private $capa;
		function __construct(){}

		function createFolder($nombreCarpeta){
			putenv('GOOGLE_APPLICATION_CREDENTIALS='.$this->pathJSON);
			$client = new Google_Client();
		    $client->useApplicationDefaultCredentials();
		    $client->setScopes(['https://www.googleapis.com/auth/drive.file']);
		    try {
		    	$service = new Google_Service_Drive($client);
        		$file = new Google_Service_Drive_DriveFile();
        		$file->setParents(array("1Jv-6ypm4pGXxAsU1IXbBSt0B-YriYBA7"));
        		$file->setName($nombreCarpeta);
        		$this->setNombreCarpeta($nombreCarpeta);
        		$file->setMimeType('application/vnd.google-apps.folder');//id de la carpeta
        		$folder = $service->files->create($file,array(['fields' => 'id']));
        		$this->subFolders(['word','excel','mapa','capa'], $folder->id, $service);

		    }catch(Google_Service_Exception $gs){
		        $m=json_decode($gs->getMessage());
		        echo $m->error->message;
		    }catch(Exception $e){
		        echo $e->getMessage();
		    }
		}
		private function subFolders($folders, $idCarpeta,$service){
			$res = [];
			foreach($folders as $folder){
				$carpeta = new Google_Service_Drive_DriveFile();
	        	$carpeta->setParents(array($idCarpeta));
	        	$carpeta->setName($folder);
	        	$carpeta->setMimeType('application/vnd.google-apps.folder');
	        	$subfile = $service->files->create($carpeta, array(['fields' => 'id']));
	        	array_push($res, $subfile->id);
			}
			$this->setWord($res[0]);
			$this->setExcel($res[1]);
			$this->setMapa($res[2]);
			$this->setCapa($res[3]);
		}
		function setPathJASON($pathJSON){$this->pathJSON = $pathJSON;}
		function setNombreCarpeta($nombreCarpeta){ $this->nombreCarpeta = $nombreCarpeta;}
		function getNombreCarpeta(){return $this->nombreCarpeta;}
		function setWord($word){$this->word = $word;}
		function setExcel($excel){$this->excel = $excel;}
		function setCapa($capa){$this->capa = $capa;}
		function setMapa($mapa){$this->mapa = $mapa;}

		function getWord(){ return $this->word;}
		function getExcel(){return $this->excel;}
		function getCapa(){ return $this->capa;}
		function getMapa(){ return $this->mapa;}

		function getListFile(){
			putenv('GOOGLE_APPLICATION_CREDENTIALS='.$this->pathJSON);
			$client = new Google_Client();
		    $client->useApplicationDefaultCredentials();
		    $client->setScopes(['https://www.googleapis.com/auth/drive.file']);
		    $service = new Google_Service_Drive($client);
		    $params = array('pageSize'=> 5,
		    	'fields' => 'nextPageToken, files(id,name)');
		    $archivos = $service->files->listFiles($params);
		    
		    foreach ($archivos as $archivo) {
		    	echo '<br/>'.$archivo->id. ' ' .$archivo->name;
		    }
		    return count($archivos);
		}
	}

?>