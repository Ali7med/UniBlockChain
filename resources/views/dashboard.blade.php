<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }} | Exam committee
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </br>
                    <table  class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <td>Isuue Number ,Date</td>
                                <td>Student</td>
                                <td>College</td>
                                <td>Stage</td>
                                <td>Year</td>
                                <td>Avarege</td>
                                <td>Avarege of 1st Rank</td>
                                <td>Study Type</td>
                                <td>Graduation Degree</td>
                                <td>Number Date Graduation Degree</td>
                                <td>All<input type="checkbox" name="" id=""></td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $Item)
                            <tr>
                                <td>{{ $Item->id }}</td>
                                <td>{{ $Item->student->name }}</td>
                                <td>{{ $Item->college->name }}</td>
                                <td>{{ $Item->stage->name }}</td>
                                <td>{{ $Item->year->name }}</td>
                                <td>{{ $Item->average }}</td>
                                <td>{{ $Item->avg_1st_rank }}</td>
                                <td>{{ $Item->study_type->name }}</td>
                                <td>{{ $Item->graduate->name }}</td>
                                <td>{{ $Item->number_date_graduation_degree }}</td>
                                <td><input type="checkbox" name="ID{{ $Item->id }}" id=""></td>
                                <td>
                                    <a href="{{ route('phase1.store',['id'=>$Item->id]) }}" class="btn btn-primary">Do</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <input type="checkbox" name="IDall" id=""> I Agree for Exporting to the Daen  <a href="{{ route('phase1.store',['id'=>0]) }}" class="btn btn-primary">Proccess</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
