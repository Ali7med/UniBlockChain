<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <form action="{{ route('master.check') }}"  method=post>
        @csrf
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-12 lg:px-12" style=" display: flex;">
            <div class="bg-white col-6 overflow-hidden shadow-sm sm:rounded-lg" >
                <div class="p-6 bg-white border-b border-gray-200" style="font-weight: bold;">
                        <div>
                            <x-label for="doc" value="Document ID" />
                            <x-input id="doc" class="block mt-1 w-full" type="text" name="doc_id"
                            value="1" required autofocus />
                        </div>
                        <div>
                            <x-label for="std" value="Student ID" />
                            <x-input id="std" class="block mt-1 w-full" type="text" name="student_id"
                            value="1" required autofocus />
                        </div>
                        <div>
                            <x-label for="uni" value="University ID" />
                            <x-input id="uni" class="block mt-1 w-full" type="text" name=""
                            value="1" required autofocus />
                        </div>
                        <div>
                            <x-label for="college_id" value="College ID" />
                            <x-input id="college_id" class="block mt-1 w-full" type="text" name="college_id"
                            value="1" required autofocus />
                        </div>
                        <div>
                            <x-label for="section_id" value="Section ID" />
                            <x-input id="section_id" class="block mt-1 w-full" type="text" name="section_id"
                            value="1" required autofocus />
                        </div>
                        <div>
                            <x-label for="stage_id" value="Stage ID" />
                            <x-input id="stage_id" class="block mt-1 w-full" type="text" name="stage_id"
                            value="1" required autofocus />
                        </div>

                </div>
            </div>
            <div class="bg-white col-6 overflow-hidden shadow-sm sm:rounded-lg" >
                <div class="p-6 bg-white border-b border-gray-200" style="font-weight: bold;">
                        <div>
                            <x-label for="year_id" value="Year" />
                            <select name="year_id" id="year_id">
                                @foreach ($years as $year)
                                    <option value="{{ $year->id }}" >{{ $year->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-label for="average" value="Average" />
                            <x-input id="average" class="block mt-1 w-full" type="text" name="average"
                            value="88" required autofocus />
                        </div>
                        <div>
                            <x-label for="avg_1st_rank" value="Average 1st Rank" />
                            <x-input id="avg_1st_rank" class="block mt-1 w-full" type="text" name="avg_1st_rank"
                            value="88" required autofocus />
                        </div>
                        <div>
                            <x-label for="study_type_id" value="Study Type" />
                            <select name="study_type_id" id="study_type_id">
                                @foreach ($studies as $study)
                                    <option value="{{ $study->id }}" >{{ $study->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-label for="graduation_degree_id" value="graduation_degree_id" />
                            <select name="graduation_degree_id" id="graduation_degree_id">
                                @foreach ($graduations as $graduation)
                                    <option value="{{ $graduation->id }}" >{{ $graduation->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-label for="number_date_graduation_degree" value="number_date_graduation_degree" />
                            <x-input id="average" class="block mt-1 w-full" type="text" name="number_date_graduation_degree"
                            value="3241 2021-01-23" required autofocus />
                        </div>
                        <div>
                            <button type="submit"  class="btn btn-primary" style="background:#0B5ED7">Check !!!</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
    </form>

</x-app-layout>
