'use strict';

module.exports = function(grunt) {
  
  grunt.loadNpmTasks('grunt-contrib-concat');

  grunt.initConfig({
    concat: {
      dist: {
        src: [
          'src/setting.php',
          'src/form.php',
          'src/update_log.php',
          'src/foot.php',
          'src/auto_link.php',
          'src/error.php',
          'src/proxy_connect.php',
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
