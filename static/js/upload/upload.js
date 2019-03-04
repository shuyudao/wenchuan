function init_uploader(){
var uploader;
var t_pwd = '';
(function(w, d, u) {
  
  function uploaderReady(token,domain) {
      // 引入Plupload 、qiniu.js后
      uploader = Qiniu.uploader({
          runtimes : 'html5,flash,html4', // 上传模式,依次退化
          browse_button : 'file', // 上传选择的点选按钮，**必需**
          uptoken : token,  // 这里的token是AJAX得到的
          // uptoken_url: 'upload.php',  //获取Token
          save_key: false,  // save_key: true, // 默认 false。若在服务端生成uptoken的上传策略中指定了 `sava_key`，则开启，SDK会忽略对key的处理
          domain : domain, // bucket 域名，下载资源时用到，这个可以到自己的七牛空间里找到具体url，**必需**
          get_new_uptoken : false, // 设置上传文件的时候是否每次都重新获取新的token
          container : 'upload_plane', // 上传区域DOM ID，默认是browser_button的父元素，
          max_file_size : '1000mb', // 最大文件体积限制
          flash_swf_url : 'Moxie.swf', // 引入flash,相对路径
          max_retries : 3, // 上传失败最大重试次数
          dragdrop : true, // 开启可拖曳上传
          drop_element : 'upload_plane', // 拖曳上传区域元素的ID，拖曳文件或文件夹后可触发上传
          chunk_size : '4mb', // 分块上传时，每片的体积
          auto_start : true, // 选择文件后自动上传，若关闭需要自己绑定事件触发上传
          unique_names:false, // unique_names: true,
          init : {
              'FilesAdded' : function(up, files) {
                  plupload.each(files, function(file) {
                      // 文件添加进队列后,处理相关的事情
                      console.log("添加文件");
                      console.log(file.name);
                      
                  });
              },
              'BeforeUpload' : function(up, file) {
                  // 每个文件上传前,处理相关的事情
              },
              'UploadProgress' : function(up, file) {
                var percent = file.percent;
                console.log("开始上传："+percent);
              //上传进度条
                  // var percent = file.percent;
                $('#upload_progress').css('display','block');
                // console.log(percent);
                $('#progress').css('width', percent+'%');
              },
              'FileUploaded' : function(up, file, info) {
                //上传完成处理
                  var file_name = file.name;
                  var fsize = file.size;
                  var qiniu_name = JSON.parse(info).key;
                  $.ajax({
                      type : "GET",
                      url : "./function/file/upload.php",  //返回信息给后台
                      data : 'file_name='+file_name+"&fsize="+fsize+"&qiniu_name="+qiniu_name,
                      success : function(data) {
                          if (data=='success') {
                            document.location.reload();
                          }
                      }
                  });
              },
              'Error' : function(up, err, errTip) {
                  // 上传出错时,处理相关的事情
                  // alert()
                  console.log("错误："+err);
              },
              'UploadComplete' : function() {
                  /// 队列文件处理完毕后,处理相关的事情
                $('#upload_progress').css('display','none');
                $('#progress').css('width', '0%');
                mizhu.toast('上传成功', 1500);

                $('#code').html(t_pwd);
                $('#get_pwd').css('z-index','999');
                $('#get_pwd').css('display','block');
              },
              'Key' : function(up, file) {
                  // 若想在前端对每个文件的key进行个性化处理，可以配置该函数
                  // 该配置必须要在 unique_names: false , save_key: false 时才生效
                  //key就是上传的文件路径
                    var key = "";
                    //获取年月日时分秒
                    var filename = file.name;
                    var index1=filename.lastIndexOf(".");
                    var index2=filename.length;
                    var postf=filename.substring(index1,index2);//后缀名
                    key += Math.random().toString(36).substr(7)+'-';
                    key += Date.parse(new Date())+postf;
                    t_pwd = key.substr(0,6); //同时，该名称前缀还是提取码
                    return key;
              }
          }
      });
  }
  // domain 为七牛空间（bucket)对应的域名，选择某个空间后可以看到
  // uploader 为一个plupload对象，继承了所有plupload的方法，参考http://plupload.com/docs
  $(d).ready(function() {
          var upToken;
          $.ajax({
              type : "POST",
              url : "./function/file/getToken.php",  // php 后台，获取upToken
              data : 'type=1',
              success : function(data) {
                
                  upload_plane.style.display = "block";
                  fixed.style.display = 'block';
                  var obj = JSON.parse(data);
                  upToken = obj.token;
                  domain = obj.domain;
                  uploaderReady(upToken,domain);
                  console.log("已获取Token接口，执行程序");
                
                  
              },
              error : function(XMLHttpRequest, textStatus, errorThrown) {
                  alert("textStatus="+textStatus+"   errorThrown="+errorThrown);
                  alert("获取token失败");
              }
          });
  });
  var close = document.getElementById("close");
   close.onclick = function(){
      upload_plane.style.display = "none";
      fixed.style.display = 'none'; 
      uploader.stop();   //停止上传
      uploader.refresh(); // 刷新实例
      uploader.splice(0, uploader.queued);
      $("#upload_progress").css("display","none");
    }

})(window, document); // 这个脚本是随着页面加载开始运行的
}