'use strict';

module.exports = function(grunt) {
  
  grunt.loadNpmTasks('grunt-contrib-concat');

  grunt.initConfig({
    concat: {
      models: {
        src: [
          'src/model/image_file.php',
          'src/model/upload_file.php' 
        ],
        dest: 'dest/models.php'
      },
      futaba: {
        options: {
          banner: "<?php require('models.php'); ?>\n",
        },
        src: [
          'src/setting.php',
          'src/form.php',
          'src/update_log.php',
          'src/foot.php',
          'src/auto_link.php',
          'src/error.php',
          'src/proxy_connect.php',
          'src/thumbnail.php',
          'src/regist.php',
          'src/get_gd_ver.php',
          'src/md5_of_file.php',
          'src/tree_delete.php',
          'src/crean_str.php',
          'src/user_delete.php',
          'src/valid.php',
          'src/admin_delete.php',
          'src/head.php',
          'src/clean_str.php',
          'src/init.php',
          'src/main.php'
        ],
        dest: 'dest/futaba.php'
      }
    }
  });
};
