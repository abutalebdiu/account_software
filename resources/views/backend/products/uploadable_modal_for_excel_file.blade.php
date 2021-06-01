            <div class="modal-dialog" role="document">
                <form method="POST" action="{{route('product_excel_file_upload')}}" enctype="multipart/form-data" >
                    @csrf 
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">  </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Upload Excel File</label>
                                <input type="file" class="form-control" name="file" accept=".csv,.xls,.xlsx"/>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <input type="submit" value="Upload File" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>