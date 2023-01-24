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
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah"><i
                                        class="fa fa-plus"></i> Tambah Data</button>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-lg dataTable">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kode</th>
                                                    <th>Nama</th>
                                                    <th>Kondisi</th>
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
                                <label>Kode Kelas</label>
                                <input type="text" placeholder="Masukkan Kode Kelas" id="data_kode_add" name="kode"
                                    value="" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label>Nama Kelas</label>
                                <input type="text" placeholder="Masukkan Nama Kelas" id="data_name_add" name="nama"
                                    value="" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label>Kondisi Jadwal</label>
                                <select type="text" placeholder="Masukkan Kondisi Jadwal" id="data_kondisi_add" name="kondisi" value="" class="form-control" required="required">
                                    <option value="SOLO">Solo</option>
                                    <option value="Group">Group</option>
                                </select>
                            </div>
                            <!-- <div class="form-group">
                                <label>Pilih Hari</label>
                                <br>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="checkAll" value="0">
                                <label class="form-check-label" for="checkAll">Semua Hari | </label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input check" type="checkbox" name="hari[]" id="senin" value="1">
                                <label class="form-check-label" for="senin">Senin</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input check" type="checkbox" name="hari[]" id="selasa" value="2">
                                <label class="form-check-label" for="selasa">Selasa</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input check" type="checkbox" name="hari[]" id="rabu" value="3">
                                <label class="form-check-label" for="rabu">Rabu</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input check" type="checkbox" name="hari[]" id="kamis" value="4">
                                <label class="form-check-label" for="kamis">Kamis</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input check" type="checkbox" name="hari[]" id="jumat" value="5">
                                <label class="form-check-label" for="jumat">Jumat</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input check" type="checkbox" name="hari[]" id="sabtu" value="6">
                                <label class="form-check-label" for="sabtu">Sabtu</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input check" type="checkbox" name="hari[]" id="minggu" value="7">
                                <label class="form-check-label" for="minggu">Minggu</label>
                                </div>
                            </div> -->
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
                        <input type="number" id="id_kelas" hidden>
                        <div>
                            <label>Kode Kelas</label>
                            <h5 id="kode_kelas"></h5>
                        </div>
                        <div>
                            <label>Nama Kelas</label>
                            <h5 id="nama"></h5>
                        </div>
                        <div>
                            <label>Kondisi</label>
                            <h5 id="kondisi"></h5>
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
                            <input type="text" name="id_kelas" id="data_id_edit" hidden>
                            <div class="form-group">
                                <label>Kode Kelas</label>
                                <input type="text" placeholder="Masukkan Kode Kelas" id="data_kode_edit" name="kode"
                                    value="" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label>Nama Kelas</label>
                                <input type="text" placeholder="Masukkan Nama Kelas" id="data_nama_edit" name="nama"
                                    value="" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label>Kondisi Jadwal</label>
                                <select type="text" placeholder="Masukkan Kondisi Jadwal" id="data_kondisi_edit" name="kondisi" value="" class="form-control" required="required">
                                    <option value="SOLO">Solo</option>
                                    <option value="GROUP">Group</option>
                                </select>
                            </div>
                            <!-- <div class="form-group">
                                <label>Pilih Hari</label>
                                <br>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="checkAll" value="0">
                                <label class="form-check-label" for="checkAll">Semua Hari | </label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input check" type="checkbox" name="hari[]" id="senin_edit" value="1">
                                <label class="form-check-label" for="senin_edit">Senin</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input check" type="checkbox" name="hari[]" id="selasa_edit" value="2">
                                <label class="form-check-label" for="selasa_edit">Selasa</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input check" type="checkbox" name="hari[]" id="rabu_edit" value="3">
                                <label class="form-check-label" for="rabu_edit">Rabu</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input check" type="checkbox" name="hari[]" id="kamis_edit" value="4">
                                <label class="form-check-label" for="kamis_edit">Kamis</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input check" type="checkbox" name="hari[]" id="jumat_edit" value="5">
                                <label class="form-check-label" for="jumat_edit">Jumat</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input check" type="checkbox" name="hari[]" id="sabtu_edit" value="6">
                                <label class="form-check-label" for="sabtu_edit">Sabtu</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input check" type="checkbox" name="hari[]" id="minggu_edit" value="7">
                                <label class="form-check-label" for="minggu_edit">Minggu</label>
                                </div>
                            </div> -->
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
				url: "<?php echo base_url('master/master_kelas/view_all/')?>",
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
				url: "<?php echo base_url('master/add_master_kelas')?>",
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
				url: "<?php echo base_url('master/edit_master_kelas')?>",
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
                    url: "<?php echo base_url('master/delete_master_kelas')?>",
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
            url: "<?php echo base_url('master/master_kelas/view_one')?>",
            type: 'POST',
            data: {id:id},
            dataType: "json",
            success: function(data){
                console.log(data)
                $('#kode_kelas').html(data['kode_kelas'])
                $('#nama').html(data['nama'])
                $('#kondisi').html(data['kondisi'])
                $('#id_kelas').val(data['id'])
            }
        })
    }
    function view_edit(){
        $('#view').modal('hide')
        $('#edit').modal('show')
        var id = $('#id_kelas').val()
        $.ajax({
            url: "<?php echo base_url('master/master_kelas/view_one')?>",
            type: 'POST',
            data: {id:id},
            dataType: "json",
            success: function(data){
                $('#data_kode_edit').val(data['kode_kelas'])
                $('#data_nama_edit').val(data['nama'])
                $('#data_id_edit').val(data['id'])
                $('#data_kondisi_edit').val(data['kondisi']).trigger('change')
                
            }
        })
    }
</script>