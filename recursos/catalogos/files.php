<?php 
	$total_imagenes = count(glob('../../images/catalogos/{*.jpg,*.gif,*.png}',GLOB_BRACE));
	echo $total_imagenes;
	
	// function contarArchivosEn ( $path, $extensionArchivo ) {
	//    $matches = glob ( $path . "*." . $extensionArchivo );
	//    $numDirectories = 0;
	 
	//    if ( $matches ) {
	//       $numDirectories = count( $matches );
	//    }
	 
	//    return $numDirectories;
	// }
	 
	// //Ejemplo de uso - Conteo de archivos con extensión .txt en la ruta actual
	// echo contarArchivosEn( '../../images/catalogos/', 'jpg' );
?>