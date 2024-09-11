<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();

$extPermitidas = array('jpg','jpeg','png','gif','bmp', 'doc','dot','rtf','docx','xlsx','xls','csv','pdf','rar','zip', '7z','gz','tgz','txt','ppt','pps','pptx','potx','ppsx','odt','ods','mp3','wma');

//$uploaddir = $this->utilidades->get_url_adjuntos();
            //$uploaddir = $_SERVER['SCRIPT_FILENAME']."/file/";
            //$nombreArchivo = basename($_SERVER['PHP_SELF']);
            //$uploaddir = str_replace($nombreArchivo, "", $uploaddir);
            $uploaddir = BASE_URL."/file/";
            //print_r($uploaddir);

            $sizeArchivo=10; //MB
            $ecxedesize=0;
            
            

            if(!is_dir($uploaddir)) 
                mkdir($uploaddir, 0777);
                date_default_timezone_set("America/Argentina/San_Juan");
               
          
            
            $data = array();

            $idmovi=$_GET['idmov'];
            $folio=$_GET['fol'];
            $fecha=date('Y-m-d H:i:s');
            $nfo=0;
            
            $error = false;
            $files = array();
           
            foreach($_FILES as $file)
            {   $nfo=$nfo+1; 
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);  //obtengo la extension
                $extperm = $extPermitidas;
                if (in_array($ext, $extperm))  //comprubo que sea una extension permitida
                {
                
                    $datos = array('nombre'=>''); // vacio
                    $consu=" INSERT INTO deta_prov(id_mov,fecha,usuario,file,foja) VALUES ('$idmovi','$fecha','','','')";
                   //this->modelo_upload->insert_file($datos); //retorna id insertado
                $idfile=mysql_query($consu,$var->links);
                
                
               //ultimoId=$this->db->insert_id(); //traigo el ultimo id
                $consu2="SELECT  last_insert_id() ";
                $result2=mysql_query($consu2,$var->links);
                $ultimoid=mysql_fetch_array($result2);
                $ultimoid = $ultimoid[0];
               
                
                

                //print_r($ultimoid);





                    //$ultimoId = $this->modelo_upload->obtener_ultimoid() + 1;   
                    //antes era asi  $nombre=$idmovi."_".date('Y-m-d')."_".$ultimoid.".".$ext;        

                    $nombre=$ultimoid."_".date('Y-m-d')."_".$idmovi."_".$folio.".".$ext;
                    $ruta = $uploaddir.$nombre;
                    //$nomgua=$file['name'];


                    $size = $file['size'] ;
                    if($size > 1024)
                    {
                        $temp = $size/1024;
                        //$temp = number_format($temp, 2, '.', '');
                        if ($temp > 1024)
                        {
                            $size = number_format($temp/1024, 2, '.', '')." MB";
                            if( ($temp/1024) > $sizeArchivo )
                                $ecxedesize=1;
                        }
                        else
                            $size = number_format($temp, 2, '.', '')." KB";
                    }
                    else 
                        $size = number_format($size, 2, '.', '')." Bytes";


                    if($ecxedesize==0)
                    {
                        $tipo = $file['type']; //mime

                        if($file && move_uploaded_file($file['tmp_name'], $ruta) )
                        //if(0)
                        {
                           
                            $consu3="UPDATE deta_prov SET file='$nombre', foja='$folio' WHERE id_detaprov='$ultimoid' ";

                            $result =mysql_query($consu3,$var->links);

                           

                             
                            if($result)
                            {
                                $arre = array('id'=>$ultimoid, 'nombre'=>$file['name'], 'size'=>$size);
                                $files[] = $arre; //id file
                            }
                        }
                        else
                        {
                            $error = true;
                            $mensaje="error al subir el archivo"; 
                        }
                    }
                    else
                        {
                            $error = true;
                            $mensaje="tamaño eccedido"; 
                        }
                         $nfo++;
                }

                else 
                {
                    $error = true;
                    $mensaje="Extensión no permitida";
                }
                    
            }
            //$idsfiles = join(',',$files);
            $data = ($error) ? array('error' => $mensaje, 'nombre'=>$file['name']) : array('files' => $files);
            
            print_r( json_encode($data) );
        
                   

?>