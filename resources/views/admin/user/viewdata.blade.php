@extends('admin.main.layout')

@section('isi')
    <a class="btn btn-sm btn-primary mb-3" onclick="add()" href="javascript:void(0)"><i class="bi bi-plus-lg"></i> Create
        User</a>

    <table class="table" id="user-datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>

    <!-- boostrap user model -->
    <div class="modal fade" id="user-modal" aria-hidden="true" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="UserModal"></h4>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)" id="UserForm" name="UserForm" class="form-horizontal" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">User Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter User Name" maxlength="50" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">User Email</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter User Email" maxlength="50" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="password" name="password"
                                    placeholder="Enter Password" required="">
                            </div>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10 mt-2">
                            <button type="submit" class="btn btn-primary" id="btn-save">Save changes
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- end bootstrap model -->


    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#user-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('user') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
                order: [
                    [0, 'desc']
                ]
            });
        });

        function add() {
            $('#UserForm').trigger("reset");
            $('#UserModal').html("Add User");
            $('#user-modal').modal('show');
            $('#id').val('');
        }

        function editFunc(id) {
            $.ajax({
                type: "POST",
                url: "{{ url('edit-user') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#UserModal').html("Edit User");
                    $('#user-modal').modal('show');
                    $('#id').val(res.id);
                    $('#name').val(res.name);
                    $('#email').val(res.email);
                    $('#password').val(res.password);

                }
            });
        }

        function deleteFunc(id) {
            if (confirm("Delete Record?") == true) {
                var id = id;
                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('delete-user') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(res) {
                        swal.fire(
                            'Berhasil',
                            'data berhasil dihapus...',
                            'success'
                        );
                        var oTable = $('#user-datatable').dataTable();
                        oTable.fnDraw(false);
                    }
                });
            }
        }
        $('#UserForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ url('store-user') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $("#user-modal").modal('hide');
                    var oTable = $('#user-datatable').dataTable();
                    oTable.fnDraw(false);
                    $("#btn-save").html('Submit');
                    $("#btn-save").attr("disabled", false);

                    swal.fire(
                        'Berhasil',
                        'data berhasil disimpan...',
                        'success'
                    );
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
    </script>
@endSection
