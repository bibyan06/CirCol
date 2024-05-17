<!-- jQuery 3 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<!-- SlimScroll -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.6/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- CK Editor -->
<script src="https://cdn.ckeditor.com/ckeditor/4.16.2/ckeditor.js"></script>

<script>
  $(function () {
    // Datatable
    $('#example1').DataTable()
    //CK Editor
    CKEDITOR.replace('editor1')
  });
</script>

<!--Magnify 
<script src="magnify/magnify.min.js"></script>
<script>
$(function(){
	$('.zoom').magnify();
});
</script>
---->

<!-- Custom Scripts -->
<script>
    $(function(){
        $('#navbar-search-input').focus(function(){
            $('#searchBtn').show();
        });

        $('#navbar-search-input').focusout(function(){
            $('#searchBtn').hide();
        });

        getCart();

        $('#productForm').submit(function(e){
            e.preventDefault();
            var product = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: 'cart_add.php',
                data: product,
                dataType: 'json',
                success: function(response){
                    if (!response.error) {
                        // Item added successfully
                        location.reload();
                    } else {
                        // Error occurred
                        showAlertMessage(response.message);
                    }
                }
            });
        });

        $(document).on('click', '.close', function(){
            $('#callout').hide();
        });
    });

    function getCart(){
        $.ajax({
            type: 'POST',
            url: 'cart_fetch.php',
            dataType: 'json',
            success: function(response){
                $('#cart_menu').html(response.list);
                $('.cart_count').html(response.count);
            }
        });
    }
</script>


<!--- custom js link -->
<script src="../assets/js/script.js"></script>

<!--- ionicon link -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<script>
    // Add this script to handle the dropdown toggle
    document.addEventListener('DOMContentLoaded', function () {
        var profileLink = document.querySelector('.nav-item.dropdown');
        var dropdownMenu = document.querySelector('.dropdown-menu');

        profileLink.addEventListener('click', function (event) {
        event.stopPropagation(); // Prevent the click event from reaching the document and closing the dropdown

        // Toggle the visibility of the dropdown menu
        if (dropdownMenu.style.display === 'block') {
            dropdownMenu.style.display = 'none';
        } else {
            dropdownMenu.style.display = 'block';
        }
        });

        // Close the dropdown when clicking outside of it
        document.addEventListener('click', function () {
        dropdownMenu.style.display = 'none';
        });
    });
</script>