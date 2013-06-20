'use strict';

var path = require('path');

module.exports = function(grunt) {

  var CURRENT_PATH = path.normalize(path.dirname(__filename));

  grunt.initConfig({
    concat: {
      repositories: {
        src: [
          'src/repository/extension.php'
        ], 
        dest: 'dest/repositories.php'
      },
      models: {
        src: [
          'src/model/image_file.php',
          'src/model/upload_file.php',
          'src/model/trip.php',
          'src/model/prettify_text.php',
        ],
        dest: 'dest/models.php'
      },
      futaba: {
        options: {
          banner: [
            "<?php require('repositories.php'); ?>\n",
            "<?php require('models.php'); ?>\n"
          ].join("")
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
    },
    shell: {
      phpRunning: {
        command: [
          'cd ' + CURRENT_PATH + '/dest',
          'php -S localhost:3000 -t .'
        ].join('&&'), 
        options: {
          stderr: true,
          stdout: true
        }
      },
      unitTest: {
        command: [
          'cd ' + CURRENT_PATH + '/src/test_src',
          'php codecept.phar run unit'
        ].join('&&'),
        options: {
          stderr: true,
          stdout: true
        } 
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-shell');

};
