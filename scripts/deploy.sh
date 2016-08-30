#!/bin/bash

# SITE_RESTORE.SH SCRIPT
#
# Requirements:
# - dev configuration.php
#

echo "********************************" >&2
echo "RUNNING SITE RESTORE.SH" >&2
echo "********************************" >&2
echo ''
echo ''
echo "Determening Source and Destination Environment" >&2

runScript=true

case "$1" in
1)  echo "Reading Production Configuration File" >&2
    source config/prod-environment.cfg
    echo "Done!" >&2
    ;;
2)  echo "Reading Test Configuration File" >&2
    source config/test-environment.cfg
    echo "Done!" >&2
    ;;
*) echo "$1 not recognized, cannot execute"
   runScript=false
   source_environment_name='Fail'
   ;;
esac


source_environment_name=$environment_name
## SOURCE ENVIRONMENT VARIABLES
# SSH
source_ssh_host=$ssh_host
# FTP
source_ftp_host=$ftp_host
source_ftp_user=$ftp_user
source_ftp_password=$ftp_password
source_ftp_base_directory=$ftp_base_directory
source_ftp_base_path=$ftp_base_path


if [ "$runScript" = true ] ; then

  echo ''
  echo ''
  echo '*************************************'
  echo 'Selected: ' $source_environment_name '->' $destination_environment_name
  echo '*************************************'
  echo ''
  echo ''


  # ZIP UP Source
  echo "*Zipping up Source Site" >&2
  ssh $source_ftp_user@$source_ssh_host "zip -r -q -X site-backup.zip $source_ftp_base_directory"

  # DOWNLOAD FILE THEN REMOVE ZIP FROM PRODUCTION
  echo "*Downloading source zip file" >&2
  scp $source_ftp_user@$source_ssh_host:site-backup.zip site-backup.zip
  ssh $source_ftp_user@$source_ssh_host "rm -r site-backup.zip"

  # UPLOAD FILE TO DEV
  echo "*uploading source zip file to destination" >&2
  scp site-backup.zip $destination_ftp_user@$destination_ssh_host:site-backup.zip

  # UNZIP ZIP FILE TO UNZIP FOLDER AND REMOVE ZIP FILE
  echo "unzipping zip file" >&2
  ssh $destination_ftp_user@$destination_ssh_host "unzip -q site-backup.zip -d unzip"
  ssh $destination_ftp_user@$destination_ssh_host "rm  site-backup.zip"

  # REMOVE OLD DEV DIRECTORY
  echo "deleting old destination site" >&2
  ssh $destination_ftp_user@$destination_ssh_host "rm -r $destination_ftp_base_directory"

  # CLEAR OUT DEV
  echo "cleaning up temporary directories" >&2
  ssh $destination_ftp_user@$destination_ssh_host "mv unzip/$source_ftp_base_directory $destination_ftp_base_directory"

  # REMOVE WORKING DIRECTORIES
  ssh $destination_ftp_user@$destination_ssh_host "rm -r unzip"
  rm site-backup.zip

  # UPDATE CONFIGURATION.PHP
  echo "Updating destination Joomla configuration file" >&2
  ssh $destination_ftp_user@$destination_ssh_host "rm $destination_ftp_base_directory/configuration.php"
  scp $destination_joomla_config_file $destination_ftp_user@$destination_ssh_host:$destination_ftp_base_directory/configuration.php
fi

echo ''
echo ''
echo "********************************" >&2
echo "COMPLETED SITE_RESTORE.SH" >&2
echo "********************************" >&2
