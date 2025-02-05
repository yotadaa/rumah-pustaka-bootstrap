<div>
    <div class="shadow-sm card">
        <div class="card-body">
            <header class="pb-2 mb-3 border-bottom">
                <div class="gap-3 mb-0 d-flex align-items-center h-100">
                    <div><a href="{{route('admin.iso.daftar')}}"
                        class="btn btn-primary d-flex align-items-center"><i class="px-2 fas fa-chevron-left"></i><span
                            class="d-none d-md-block">Kembali</span></a></div>
                <h3 class="fw-semibold">Daftar Divisi</h3>
            </header>
            <main>
                <table class="table">
                    <thead class="border-bottom">
                        <tr class="text-muted">
                            <th class="py-2">No</th>
                            <th class="py-2">Nama Divisi</th>
                            <th class="py-2">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($divisions as $division)
                            <tr class="@if ($loop->odd) bg-light @endif">
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $division->name }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.iso.komponen', ['id' => $id, 'role_id' => $division->id]) }}" 
                                           class="btn  btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                
                                        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-cogs"></i> <!-- Gear icon for actions -->
                                        </button>
                                        <ul class="dropdown-menu">
                                            @if (auth()->user()->pangkat == 0)
                                                <li>
                                                    <button class="dropdown-item text-warning" title="Edit">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-danger" title="Delete">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </li>
                                            @endif
                                            <li>
                                                <button class="dropdown-item text-success" title="Download">
                                                    <i class="fas fa-download"></i> Download
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </main>
        </div>
    </div>
</div>
