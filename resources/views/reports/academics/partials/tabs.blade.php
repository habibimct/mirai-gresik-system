<ul class="nav nav-tabs mb-3"
    id="academicTab"
    role="tablist">

    {{-- KEHADIRAN --}}
    <li class="nav-item">

        <a class="nav-link active"
           id="attendance-tab"
           data-toggle="pill"
           href="#attendance"
           role="tab"
           aria-controls="attendance"
           aria-selected="true">

            <i class="fas fa-calendar-check mr-1"></i>
            Kehadiran

        </a>

    </li>


    {{-- PENILAIAN --}}
    <li class="nav-item">

        <a class="nav-link"
           id="score-tab"
           data-toggle="pill"
           href="#score"
           role="tab"
           aria-controls="score"
           aria-selected="false">

            <i class="fas fa-star mr-1"></i>
            Penilaian

        </a>

    </li>


    {{-- NILAI SIKAP --}}
    <li class="nav-item">

        <a class="nav-link"
           id="attitude-tab"
           data-toggle="pill"
           href="#attitude"
           role="tab"
           aria-controls="attitude"
           aria-selected="false">

            <i class="fas fa-user-check mr-1"></i>
            Nilai Sikap

        </a>

    </li>

</ul>


<div class="tab-content"
     id="academicTabContent">

    {{-- KEHADIRAN --}}
    <div class="tab-pane fade show active"
         id="attendance"
         role="tabpanel"
         aria-labelledby="attendance-tab">

        @include('reports.academics.partials.attendance')

    </div>


    {{-- PENILAIAN --}}
    <div class="tab-pane fade"
         id="score"
         role="tabpanel"
         aria-labelledby="score-tab">

        @include('reports.academics.partials.score')

    </div>


    {{-- NILAI SIKAP --}}
    <div class="tab-pane fade"
         id="attitude"
         role="tabpanel"
         aria-labelledby="attitude-tab">

        @include('reports.academics.partials.attitude')

    </div>

</div>