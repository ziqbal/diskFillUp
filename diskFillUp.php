<?php

// TODO
// Pick random '_cache_' directory
// Progress show % done
// Progress ETA
// fallocate -l 100G file2


// Disk Fill Up
// Fills local disk with files until some threshold

$_CONFIG = array( ) ;
//$_CONFIG[ "disk" ] = "/" ; // used to determine disk free space
$_CONFIG[ "disk" ] = "/media/user/DATA" ; // used to determine disk free space
$_CONFIG[ "dirwidth" ] = 3 ; // width of subdirectories (aaa...)
$_CONFIG[ "dirdepth" ] = 3 ; // total number fo sub durectories (x/y/z....)
$_CONFIG[ "filesize" ] = 1 * 1024 * 1024 * 100 ; // Size of generated files (50MB)
$_CONFIG[ "threshold" ] = 1 * 1024 * 1024 * 1024 ; // How much free space to leave (1GB)

/////////

$dirslen = $_CONFIG[ "dirwidth" ] * $_CONFIG[ "dirdepth" ] ;

$mindiskfreespace = $_CONFIG[ "threshold" ] + $_CONFIG[ "filesize" ] ;

$frame = 0 ;

while( true ) {

	$diskfreespace = disk_free_space( $_CONFIG[ "disk" ] ) ;

	if( $diskfreespace <= $mindiskfreespace ) break ;

	( ( ( $frame++ ) % 10 ) == 0 ) ? print( "\n[ $diskfreespace ] ." ) : print( '.' ) ; 

	$rndString = hash( 'sha256' , uniqid( 'VkU0WaS38G0fiqIhcsAW' , true ).bin2hex( openssl_random_pseudo_bytes( 256 ) ) ) ;

	$dir = '_cache_/'.implode( '/' , str_split( substr( $rndString , 0 , $dirslen ) , $_CONFIG[ 'dirwidth' ] ) ) ;

	if( !is_dir( $dir ) ) mkdir( $dir , 0777 , true ) ;

	file_put_contents( $dir.'/'.substr( $rndString , $dirslen ).'.tmp' , openssl_random_pseudo_bytes( $_CONFIG[ 'filesize' ] ) ) ;

}	
