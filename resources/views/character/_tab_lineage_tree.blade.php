<div class="container text-center">
    <div class="row">
        <div class="col">
            <div class="border-bottom mb-1">
                <span class="font-weight-bold"><i class="fa-solid fa-sun"></i></span><br>{!! $line['sire'] !!}
            </div>
            <div class="row">
                <div class="col">
                    <div class="border-bottom mb-1">
                        <abbr class="font-weight-bold" title="Sire's Sire"><i class="fa-solid fa-sun"></i><i class="fa-solid fa-sun"></i></abbr><br>{!! $line['sire_sire'] !!}
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-1">
                                <abbr title="Sire's Sire's Sire"><i class="fa-solid fa-sun"></i><i class="fa-solid fa-sun"></i><i class="fa-solid fa-sun"></i></abbr><br>{!! $line['sire_sire_sire'] !!}
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-1">
                                <abbr title="Sire's Sire's Dam"><i class="fa-solid fa-sun"></i><i class="fa-solid fa-sun"></i><i class="fa-solid fa-moon"></i></abbr><br>{!! $line['sire_sire_dam'] !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="border-bottom mb-1">
                        <abbr class="font-weight-bold" title="Sire's Dam"><i class="fa-solid fa-sun"></i><i class="fa-solid fa-moon"></i></abbr><br>{!! $line['sire_dam'] !!}
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-1">
                                <abbr title="Sire's Dam's Sire"><i class="fa-solid fa-sun"></i><i class="fa-solid fa-moon"></i><i class="fa-solid fa-sun"></i></abbr><br>{!! $line['sire_dam_sire'] !!}
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-1">
                                <abbr title="Sire's Dam's Dam"><i class="fa-solid fa-sun"></i><i class="fa-solid fa-moon"></i><i class="fa-solid fa-moon"></i></abbr><br>{!! $line['sire_dam_dam'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="border-bottom mb-1">
                <span class="font-weight-bold"><i class="fa-solid fa-moon"></i></span><br>{!! $line['dam'] !!}
            </div>
            <div class="row">
                <div class="col">
                    <div class="border-bottom mb-1">
                        <abbr class="font-weight-bold" title="Dam's Sire"><i class="fa-solid fa-moon"></i><i class="fa-solid fa-sun"></i></abbr><br>{!! $line['dam_sire'] !!}
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-1">
                                <abbr title="Dam's Sire's Sire"><i class="fa-solid fa-moon"></i><i class="fa-solid fa-sun"></i><i class="fa-solid fa-sun"></i></abbr><br>{!! $line['dam_sire_sire'] !!}
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-1">
                                <abbr title="Dam's Sire's Dam"><i class="fa-solid fa-moon"></i><i class="fa-solid fa-sun"></i><i class="fa-solid fa-moon"></i></abbr><br>{!! $line['dam_sire_dam'] !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="border-bottom mb-1">
                        <abbr class="font-weight-bold" title="Dam's Dam"><i class="fa-solid fa-moon"></i><i class="fa-solid fa-moon"></i></abbr><br>{!! $line['dam_dam'] !!}
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-1">
                                <abbr title="Dam's Dam's Sire"><i class="fa-solid fa-moon"></i><i class="fa-solid fa-moon"></i><i class="fa-solid fa-sun"></i></abbr><br>{!! $line['dam_dam_sire'] !!}
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-1">
                                <abbr title="Dam's Dam's Dam"><i class="fa-solid fa-moon"></i><i class="fa-solid fa-moon"></i><i class="fa-solid fa-moon"></i></abbr><br>{!! $line['dam_dam_dam'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
