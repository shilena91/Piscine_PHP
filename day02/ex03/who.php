#!/usr/bin/php
<?php

/*
00000000  75 74 6d 70 78 2d 31 2e  30 30 00 00 00 00 00 00  |utmpx-1.00......|
00000010  00 00 00 00 00 00 00 00  00 00 00 00 00 00 00 00  |................|
*
00000120  00 00 00 00 00 00 00 00  0a 00 00 00 00 00 00 00  |................|
00000130  00 00 00 00 00 00 00 00  00 00 00 00 00 00 00 00  |................|
*
00000390  00 00 00 00 00 00 00 00  01 00 00 00 02 00 00 00  |................|
000003a0  2e 67 15 5f 00 00 00 00  00 00 00 00 00 00 00 00  |.g._............|
000003b0  00 00 00 00 00 00 00 00  00 00 00 00 00 00 00 00  |................|
*
000004e0  00 00 00 00 00 00 00 00  68 6f 70 68 61 6d 00 00  |........hopham..|
000004f0  00 00 00 00 00 00 00 00  00 00 00 00 00 00 00 00  |................|
*
000005e0  00 00 00 00 00 00 00 00  2f 00 01 01 63 6f 6e 73  |......../...cons|
000005f0  6f 6c 65 00 00 00 00 00  00 00 00 00 00 00 00 00  |ole.............|
00000600  00 00 00 00 00 00 00 00  00 00 00 00 88 00 00 00  |................|
00000610  07 00 00 00 e1 6c 15 5f  14 eb 0c 00 00 00 00 00  |.....l._........|
00000620  00 00 00 00 00 00 00 00  00 00 00 00 00 00 00 00  |................|
*
00000750  00 00 00 00 00 00 00 00  00 00 00 00 68 6f 70 68  |............hoph|
00000760  61 6d 00 00 00 00 00 00  00 00 00 00 00 00 00 00  |am..............|
00000770  00 00 00 00 00 00 00 00  00 00 00 00 00 00 00 00  |................|
*
00000850  00 00 00 00 00 00 00 00  00 00 00 00 73 30 30 30  |............s000|
00000860  74 74 79 73 30 30 30 00  00 00 00 00 00 00 00 00  |ttys000.........|
00000870  00 00 00 00 00 00 00 00  00 00 00 00 00 00 00 00  |................|
00000880  fd 05 00 00 07 00 00 00  e4 6c 15 5f 37 0a 0e 00  |.........l._7...|
00000890  00 00 00 00 00 00 00 00  00 00 00 00 00 00 00 00  |................|
*
000009d0

% man endutxent
...

struct utmpx {
   char ut_user[_UTX_USERSIZE];     login name 
   char ut_id[_UTX_IDSIZE];         id 
   char ut_line[_UTX_LINESIZE];     tty name
   pid_t ut_pid;                    process id creating the entry
   short ut_type;                   type of this entry
   struct timeval ut_tv;            time entry was created
   char ut_host[_UTX_HOSTSIZE];     host name
   __uint32_t ut_pad[16];           reserved for future use
 };

_UTX_USERSIZE seems to be 256 bytes long (0x5e8 - 0x4e8)
_UTX_IDSIZE               4   bytes long (0x5ec - 0x5e8)
_UTX_LINESIZE             32  bytes long (0x60c - 0x5ec)
pid_t                     4   bytes long (per sys/types.h)
short                     2   bytes long (should be, but it is actually 4 bytes long :PepeRain:)

% man gettimeofday
...

 struct timeval {
   time_t      tv_sec;      seconds 
   suseconds_t tv_usec;     microseconds
 };

time_t                    8 bytes long (per sys/types.h)
*/

$utmpx = fopen('/var/run/utmpx', 'rb');
if (!$utmpx)
	return;

date_default_timezone_set('Europe/Helsinki');

while (1) {
	$data = fread($utmpx, 628);
	if (!$data)
		break;
	
	$who_username = substr($data, 0, 256);
	$who_id = substr($data, 256, 4);
	$who_console = substr($data, 260, 32);

	$who_pid = substr($data, 292, 4);
	$who_pid = unpack('S', $who_pid)[1];

	$who_type = substr($data, 296, 4);
	$who_type = unpack('S', $who_type)[1];

	if ($who_type !== 7)
		continue;

	$who_time = substr($data, 300, 8);
	$who_time = unpack('L', $who_time)[1];
	$who_time = date('M d H:i', $who_time);

	echo $who_username . ' ' . $who_console . ' ' . $who_time . "\n";
}

fclose($utmpx);
