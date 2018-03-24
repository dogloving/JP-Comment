### JP-Comment使用方法

1. 在你的head标签中添加

   ```javascript
       <link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">  
       <script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
       <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
       <link rel="stylesheet" type="text/css" href="https://www.nkuhjp.com/JP-Comment/assets/css/comments.css">
   ```

2. 在合适的地方添加下面代码，一般是body最下面(用来放评论)

   ```javascript
   <div class="jp-comments" style="display:block;width:100%;margin-top:30px;">
       <div class="form-horizontal center-class" role="form" style="display:block;width:50%;margin-left:auto;margin-right:auto;">
           <div class="form-group has-feedback" style="font-size:2em;">评论(共&nbsp;<span id="jp-count"></span>&nbsp;条)</div>
           <div class="form-group has-feedback">
               <div>
                   <span class="glyphicon glyphicon-user form-control-feedback"></span>
                   <input type="text" class="form-control" id="jp-nickname" name="nickname" placeholder="你的昵称" autofocus>
               </div>
           </div>
           <div class="form-group has-feedback">
               <div>
                   <i></i>
                   <span class="glyphicon glyphicon-globe form-control-feedback"></span>
                   <input type="text" class="form-control" id="jp-site" name="site" placeholder="你的站点">
               </div>
           </div>
           <div class="form-group has-feedback">
               <div>
                   <i></i>
                   <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                   <textarea class="form-control" id="jp-content" name="content" placeholder="你的评论" rows="6"></textarea>
               </div>
           </div>
           <button class="btn btn-primary" style="display:block;width:10%;height:5vh;margin-left:auto;margin-right:auto;" id="jp-smt">提交</button>
       </div>
       <ul class="list-group" style="display:block;width:50%;margin-left:auto;margin-right:auto;margin-top:30px;" id="jp-cm"></ul>
   </div>
   <script type="text/javascript" src="https://www.nkuhjp.com/JP-Comment/assets/js/comments.js"></script>
   ```

   ### 效果图

   ![](https://raw.githubusercontent.com/dogloving/JP-Comment/master/assets/img/show.gif)
