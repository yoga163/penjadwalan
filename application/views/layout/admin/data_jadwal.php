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
                                <li class="breadcrumb-item">Data Jadwal</li>
                                <li class="breadcrumb-item"><?= $title ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="row" id="basic-table">
                    <div class="col-12 col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <form id="form_proses">
                                    <div class="form-group">
                                        <label>Tanggal Pelaksanaan</label>
                                        <input type="text" placeholder="Masukkan Tanggal" name="tanggal" value="" class="form-control date-range">
                                        
                                    </div>
                                    <div class="form-group">
                                        <label>Jumlah Populasi</label>
                                        <input type="number" name="jml_populasi" value="50" class="form-control" step=".01">
                                    </div>
                                    <div class="form-group">
                                        <label>Probabilitas Crossover (0-1)</label>
                                        <input type="number" name="probabilitas_crossover" value="0.70" class="form-control" step=".01" min="0">
                                    </div>
                                    <div class="form-group">
                                        <label>Probailitas Mutasi (0-1)</label>
                                        <input type="number" name="probabilitas_mutasi" value="0.20" class="form-control" step=".01" min="0">
                                    </div>
                                    <div class="form-group">
                                        <label>Jumlah Generasi (Jumlah Iterasi)</label>
                                        <input type="number" name="jml_generasi" value="800" class="form-control" step=".01">
                                    </div>
                                </form>
                                <div class="row" id="basic-table">
                                    <div class="col-md-6">
                                        <button class="btn btn-primary" onclick="do_add()"><i class="fa fa-plus"></i> Proses</button>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end">
                                        <button class="btn btn-info" onclick="do_view()"><i class="fa fa-magnifying-glass"></i> Lihat Jadwal</button>
                                    </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-lg dataTable">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Hari</th>
                                                    <th>Kelas</th>
                                                    <th>Jam</th>
                                                    <th>Mapel</th>
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
                                <label>Kode Mapel</label>
                                <input type="text" placeholder="Masukkan Kode Mapel" id="data_kode_add" name="kode" value="" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label>Nama Mapel</label>
                                <input type="text" placeholder="Masukkan Nama Mapel" id="data_name_add" name="nama" value="" class="form-control" required="required">
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
        <div class="modal modal-lg fade" id="view" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Jadwal</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-lg" id="jadwal">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Hari</th>
                                        <th>Kelas</th>
                                        <th>Jam</th>
                                        <th>Mapel</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
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
                            <input type="text" name="id_mapel" id="data_id_edit" hidden>
                            <div class="form-group">
                                <label>Kode Mapel</label>
                                <input type="text" placeholder="Masukkan Kode Mapel" id="data_kode_edit" name="kode"
                                    value="" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label>Nama Mapel</label>
                                <input type="text" placeholder="Masukkan Nama Mapel" id="data_nama_edit" name="nama"
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
        $(".date-range").on('cancel.daterangepicker', function(ev, picker) {
                $('.date-range').val('')
            });
		$('.dataTable').DataTable( {
			ajax: {
				url: "<?php echo base_url('jadwal/data_jadwal/view_all/')?>",
				type: 'POST',
			},
			columnDefs: [
			{   targets: 0, 
				width: '5%',
				render: function ( data, type, full, meta ) {
					return '<center>'+(meta.row+1)+'.</center>';
				}
			},
            {   targets: 1, 
				width: '20%',
			},
			]
		});
	});
    function do_add(){
        if($("#form_proses")[0].checkValidity()) {
            $.ajax({
				url: "<?php echo base_url('jadwal/proses_jadwal')?>",
				type: 'POST',
                data: $('#form_proses').serialize(),
                dataType: "json",
                success: function(data){
                    if(data){
                        Swal.fire({
                            title: 'Success!',
                            icon: 'success',
                        })
                        $('.dataTable').DataTable().ajax.reload();
                    }
                }
			})
        }else{
            notValidParamx();
        } 
    }
    function do_edit(){
        if($("#form_edit")[0].checkValidity()) {
            $.ajax({
				url: "<?php echo base_url('jadwal/proses_jadwal')?>",
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
                    url: "<?php echo base_url('jadwal/delete_data_jadwal')?>",
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
            url: "<?php echo base_url('jadwal/data_jadwal/view')?>",
            type: 'POST',
            dataType: "json",
            success: function(data){
                $('#jadwal').append(data['table'])
            }
        })
    }
    function view_edit(){
        $('#view').modal('hide')
        $('#edit').modal('show')
        var id = $('#id_mapel').val()
        $.ajax({
            url: "<?php echo base_url('jadwal/data_jadwal/view_one')?>",
            type: 'POST',
            data: {id:id},
            dataType: "json",
            success: function(data){
                $('#data_kode_edit').val(data['kode_mapel'])
                $('#data_nama_edit').val(data['nama'])
                $('#data_id_edit').val(data['id'])
            }
        })
    }
</script>