            </div>

        </div>

    </div>
    <!-- /.container -->
	
	<hr>

    <div class="container">


        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-6">
                    <span class="pull-left">Copyright &copy; Peltech 2016</span><br />
					<span class="pull-left"><a href="<?=$config->get('nav/base');?>about"><?=$config->get('lang/general/about');?></a></span>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="<?=$config->get('nav/extlink');?>js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?=$config->get('nav/extlink');?>js/bootstrap.min.js"></script>
	
	<!-- js file for the page if used -->
	<script src="<?=$config->get('nav/extlink');?>js/content/<?=$config->get('nav/page_include');?>.js"></script>

</body>

</html>