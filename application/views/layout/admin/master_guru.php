<div id="app">

    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3><?= $title ?></h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>pages">Dashboard</a></li>
                                <li class="breadcrumb-item">Master Data</li>
                                <li class="breadcrumb-item"><?= $title ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="row" id="basic-table">
                    <div class="col-12 col-md-7">
                        <div class="card">
                            <div class="card-header">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah"><i class="fa fa-plus"></i> Tambah Data</button>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-lg dataTable">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kode</th>
                                                    <th>Nama Guru</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- modal Tambah -->
        <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form_add">
                            <div class="form-group">
                                <label>Kode Guru</label>
                                <input type="text" placeholder="Masukkan Kode Guru" id="data_kode_add" name="kode"
                                    value="" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label>Nama Guru</label>
                                <input type="text" placeholder="Masukkan Nama Guru" id="data_name_add" name="nama"
                                    value="" class="form-control" required="required">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="do_add()" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal View -->
        <div class="modal fade" id="view" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="number" id="id_guru" hidden>
                        <div>
                            <label>Kode Guru</label>
                            <h5 id="kode_guru"></h5>
                        </div>
                        <div>
                            <label>Nama Guru</label>
                            <h5 id="nama"></h5>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="view_edit()" class="btn btn-primary"><i class="fa fa-pen"></i>Edit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal edit -->
        <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form_edit">
                            <input type="text" name="id_guru" id="data_id_edit" hidden>
                            <div class="form-group">
                                <label>Kode Guru</label>
                                <input type="text" placeholder="Masukkan Kode Guru" id="data_kode_edit" name="kode"
                                    value="" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label>Nama Guru</label>
                                <input type="text" placeholder="Masukkan Nama Guru" id="data_nama_edit" name="nama"
                                    value="" class="form-control" required="required">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="do_edit()" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('_partial/main/script')?>
<script>
    $(document).ready(function(){
		$('.dataTable').DataTable( {
			ajax: {
				url: "<?php echo base_url('master/master_guru/view_all/')?>",
				type: 'POST',
			},
			columnDefs: [
			{   targets: 0, 
				width: '5%',
				render: function ( data, type, full, meta ) {
					return '<center>'+(meta.row+1)+'.</center>';
				}
			},
			]
		});
	});
    function do_add(){
        if($("#form_add")[0].checkValidity()) {
            $.ajax({
				url: "<?php echo base_url('master/add_master_guru')?>",
				type: 'POST',
                data: $('#form_add').serialize(),
                dataType: "json",
                success: function(data){
                    if(data){
                        Swal.fire({
                            title: 'Success!',
                            icon: 'success',
                        })
                    }
                    console.log(data)
                }
			})
            $('#form_add')[0].reset();
            $('#tambah').modal('hide')
            $('.dataTable').DataTable().ajax.reload();
        }else{
            notValidParamx();
        } 
    }
    function do_edit(){
        if($("#form_edit")[0].checkValidity()) {
            $.ajax({
				url: "<?php echo base_url('master/edit_master_guru')?>",
				type: 'POST',
                data: $('#form_edit').serialize(),
                dataType: "json",
                success: function(data){
                    if(data){
                        Swal.fire({
                            title: 'Success!',
                            icon: 'success',
                        })
                    }else{
                        Swal.fire({
                            title: 'Error!',
                            icon: 'error',
                        })
                    }
                    console.log(data)
                }
			})
            $('#form_edit')[0].reset();
            $('#edit').modal('hide')
            $('.dataTable').DataTable().ajax.reload();
        }else{
            notValidParamx();
        } 
    }
    function do_delete(id){
        Swal.fire({
            title: 'Yakin akan hapus data?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo base_url('master/delete_master_guru')?>",
                    type: 'POST',
                    data: {id:id},
                    dataType: "json",
                    success: function(data){
                        if(data){
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                                )
                        }
                        $('.dataTable').DataTable().ajax.reload();
                        console.log(data)
                    }
                })
                
            }
            })
            
    }
    function do_view(id){
        $('#view').modal('show')
        $.ajax({
            url: "<?php echo base_url('master/master_guru/view_one')?>",
            type: 'POST',
            data: {id:id},
            dataType: "json",
            success: function(data){
                console.log(data)
                $('#kode_guru').html(data['kode_guru'])
                $('#nama').html(data['nama'])
                $('#id_guru').val(data['id'])
            }
        })
    }
    function view_edit(){
        $('#view').modal('hide')
        $('#edit').modal('show')
        var id = $('#id_guru').val()
        $.ajax({
            url: "<?php echo base_url('master/master_guru/view_one')?>",
            type: 'POST',
            data: {id:id},
            dataType: "json",
            success: function(data){
                $('#data_kode_edit').val(data['kode_guru'])
                $('#data_nama_edit').val(data['nama'])
                $('#data_id_edit').val(data['id'])
            }
        })
    }
</script>