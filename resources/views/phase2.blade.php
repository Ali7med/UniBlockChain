<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Algorithm Phase 2 (Head University)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in! {{ auth()->user()->name }}
                </hr>
                </br>

                            @foreach ($data as $Item)
                            <div class="card" >
                                <div class="card-body">
                                  {{-- <h5 class="card-title">{{ $Item->student->name }}</h5> --}}
                                  <p class="card-text">
                                    <table  class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <td>{{ $Item->id }}</td>
                                                <th>Student</th>
                                                <td>{{ $Item->student->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>College</th>
                                                <td>{{ $Item->operation->college->name }}</td>
                                                <th>Stage</th>
                                                <td>{{ $Item->operation->stage->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Year</th>
                                                <td>{{ $Item->operation->year->name }}</td>
                                                <th>Avarege</th>
                                                <td>{{ $Item->operation->average }}</td>
                                            </tr>
                                            <tr>
                                                <th>Avarege of 1st Rank</th>
                                                <td>{{ $Item->operation->avg_1st_rank }}</td>
                                                <th>Study Type</th>
                                                <td>{{ $Item->operation->study_type->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Graduation Degree</th>
                                                <td>{{ $Item->operation->graduate->name }}</td>
                                                <th>Number Date Graduation Degree</th>
                                                <td>{{ $Item->operation->number_date_graduation_degree }}</td>
                                            </tr>
                                            <tr>
                                                <th>Department Head</th>
                                                <td>{{ $Item->operation->user->name }}</td>
                                                <th>Singture Time</th>
                                                <td>{{ $Item->created_at }}</td>
                                            </tr>
                                            <tr>
                                                <th>Orginal Hash</th>
                                                <th>{{ $Item->hash2}}</th>
                                            </tr>
                                            <tr>
                                                <th>Dean Hash</th>
                                                <th>{{ $Item->phase1->hash }}</th>
                                                <th><i
                                                    @if ($Item->hash2==$Item->hash && $Item->hash2==$Item->phase1->hash)
                                                    style="color:green;font-size:25px" class="fa-solid fa-badge-check"
                                                    @else
                                                    style="color:red;font-size:25px" class="fa-solid fa-folder-xmark"
                                                    @endif
                                                    ></i>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Current Hash</th>
                                                <th>{{ $Item->hash }}</th>
                                                <th><i
                                                    @if ($Item->hash2==$Item->hash && $Item->hash2==$Item->phase1->hash)
                                                    style="color:green;font-size:25px" class="fa-solid fa-badge-check"
                                                    @else
                                                    style="color:red;font-size:25px" class="fa-solid fa-folder-xmark"
                                                    @endif
                                                    ></i>
                                                </th>                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            </tr>
                                        </tbody>
                                    </table>
                                  </p>
                                    @if ($Item->hash2==$Item->hash && $Item->hash2==$Item->phase1->hash)
                                        <a href="{{ route('phase2.store',['id'=>$Item->id]) }}" class="btn btn-primary">Approve !!!</a>
                                    @else
                                        <a href="#" class="btn btn-outline-danger">Not Approved !!!</a>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            <hr>
                    <input type="checkbox" name="IDAll" id=""> I Agree for Exporting to the Afference department  <a href="{{ route('phase2.store',['id'=>0]) }}" class="btn btn-primary">Proccess</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
