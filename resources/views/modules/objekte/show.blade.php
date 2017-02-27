@extends('layouts.main-without-menu')

@section('breadcrumbs')
    @if(starts_with(URL::previous(), route('web::objekte::index')))
        <a href="{{ URL::previous() }}" class="breadcrumb">Objekte</a>
    @else
        <a href="{{ route('web::objekte::index') }}" class="breadcrumb">Objekte</a>
    @endif
    <span class="breadcrumb">@include('shared.entities.objekt', ['entity' => $objekt, 'icons' => false])</span>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-title">
                        <div class="row" style="line-height: 24px; margin-bottom: 12px; margin-top: 12px">
                            <div class="col-xs-10">
                                @include('shared.entities.objekt', ['entity' => $objekt])
                            </div>
                            <div class="col-xs-2 end-xs">
                                <a href="{{ route('web::objekte::legacy', ['objekte_raus' => 'objekt_aendern', 'objekt_id' => $objekt->OBJEKT_ID]) }}"><i
                                            class="mdi mdi-pencil"></i></a>
                                <a href="{{ route('web::details::legacy', ['option' => 'details_hinzu', 'detail_tabelle' => 'OBJEKT', 'detail_id' => $objekt->OBJEKT_ID]) }}"><i
                                            class="mdi mdi-table-edit"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-3 detail">
                            <i class="mdi mdi-mail-ru"></i>
                            @php
                                $emails = collect();
                                foreach($objekt->mieter()->with('emails')->get() as $mieter) {
                                    if(!$mieter->emails->isEmpty()) {
                                        foreach ($mieter->emails as $email) {
                                            if($email->DETAIL_INHALT != '') {
                                                $emails->push(trim($email->DETAIL_INHALT));
                                            }
                                        }
                                    }
                                }
                                $href = "mailto:?bcc=";
                                foreach ($emails as $email) {
                                    $href .= $email . ', ';
                                }
                            @endphp
                            <a href="{{ $href }}">E-Mail an Mieter ({{ $emails->count() }})</a>
                        </div>
                        <div class="col-xs-6 col-sm-3 detail">
                            <i class="mdi mdi-key tooltipped" data-position="bottom" data-delay="50" data-tooltip="Eigentümer"></i>
                            @include('shared.entities.partner', ['entity' => $objekt->eigentuemer])
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(!$objekt->commonDetails->isEmpty())
            <div class="col-xs-12 col-sm-6">
                <div class="card card-expandable">
                    <div class="card-content">
                        <div class="card-title">Allgemeine Details ({{ $objekt->commonDetails->count() }})</div>
                        <table class="striped">
                            <thead>
                            <th>Typ</th>
                            <th>Wert</th>
                            <th>Bemerkung</th>
                            </thead>
                            <tbody>
                            @foreach( $objekt->commonDetails as $detail )
                                <tr>
                                    <td>
                                        {{ $detail->DETAIL_NAME }}
                                    </td>
                                    <td>
                                        {{ $detail->DETAIL_INHALT }}
                                    </td>
                                    <td>
                                        {{ $detail->DETAIL_BEMERKUNG }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        @if(!$objekt->haeuser->isEmpty())
            <div class="col-xs-12 col-sm-3">
                <div class="card card-expandable">
                    <div class="card-content">
                        <span class="card-title"><a
                                    href="{{ route('web::haeuser::index', ['q' => '!haus(objekt(id=' . $objekt->OBJEKT_ID . '))']) }}">Häuser ({{ $objekt->haeuser->count() }})
                            </a></span>
                        <table class="striped">
                            <thead>
                            <th>Haus</th>
                            </thead>
                            <tbody>
                            @foreach( $objekt->haeuser()->defaultOrder()->get() as $haus )
                                <tr>
                                    <td>
                                        @include('shared.entities.haus', [ 'entity' => $haus])
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        @if(!$objekt->einheiten->isEmpty())
            <div class="col-xs-12 col-sm-3">
                <div class="card card-expandable">
                    <div class="card-content">
                        <span class="card-title"><a
                                    href="{{ route('web::einheiten::index', ['q' => '!einheit(objekt(id=' . $objekt->OBJEKT_ID . '))']) }}">Einheiten ({{ $objekt->einheiten->count() }})
                            </a></span>
                        <table class="striped">
                            <thead>
                            <th>Einheit</th>
                            </thead>
                            <tbody>
                            @foreach( $objekt->einheiten()->defaultOrder()->get() as $einheit )
                                <tr>
                                    <td>
                                        @include('shared.entities.einheit', [ 'entity' => $einheit])
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        @if(!$objekt->mieter()->get()->isEmpty())
            <div class="col-xs-12 col-sm-3">
                <div class="card card-expandable">
                    <div class="card-content">
                        <span class="card-title"><a
                                    href="{{ route('web::personen::index', ['q' => '!person(mietvertrag(objekt(id=' . $objekt->OBJEKT_ID . ') laufzeit=' . \Carbon\Carbon::today()->toDateString() . '))']) }}">Mieter ({{ $objekt->mieter()->get()->count() }})
                            </a></span>
                        <table class="striped">
                            <thead>
                            <th>Mieter</th>
                            </thead>
                            <tbody>
                            @foreach( $objekt->mieter()->defaultOrder()->with('sex')->get() as $mieter )
                                <tr>
                                    <td>
                                        @include('shared.entities.person', [ 'entity' => $mieter ])
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-xs-12 col-sm-6">
            <div class="card card-expandable">
                <div class="card-content">
                    <span class="card-title">Berichte</span>
                    <table class="striped">
                        <thead>
                        <th>Bericht</th>
                        <th>Beschreibung</th>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <a target="_blank"
                                   href="{{ route('web::objekte::legacy', ['objekte_raus' => 'checkliste', 'objekt_id' => $objekt->OBJEKT_ID]) }}">Hauswart
                                    Checkliste <i class="mdi mdi-file-pdf"></i></a>
                            </td>
                            <td>
                                Checkliste für Rundgang
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a target="_blank"
                                   href="{{ route('web::objekte::legacy', ['objekte_raus' => 'mietaufstellung', 'objekt_id' => $objekt->OBJEKT_ID]) }}">Mietaufstellung
                                    <i class="mdi mdi-file-pdf"></i></a>
                            </td>
                            <td>
                                Mietaufstellung des aktuellen Monats
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a target="_blank"
                                   href="{{ route('web::objekte::legacy', ['objekte_raus' => 'mietaufstellung_m_j', 'objekt_id' => $objekt->OBJEKT_ID, 'monat' => \Carbon\Carbon::now()->month, 'jahr' => \Carbon\Carbon::now()->year]) }}">Mietaufstellung
                                    Monatsjournal<i class="mdi mdi-file-pdf"></i></a>
                                <a target="_blank"
                                   href="{{ route('web::objekte::legacy', ['objekte_raus' => 'mietaufstellung_m_j', 'objekt_id' => $objekt->OBJEKT_ID, 'monat' => \Carbon\Carbon::now()->month, 'jahr' => \Carbon\Carbon::now()->year, 'XLS']) }}"><i
                                            class="mdi mdi-file-excel"></i></a>
                            </td>
                            <td>
                                Mietaufstellung des aktuellen Monats in Journalansicht
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a target="_blank"
                                   href="{{ route('web::mietkontenblatt::legacy', ['anzeigen' => 'alle_mkb', 'objekt_id' => $objekt->OBJEKT_ID]) }}">Alle
                                    Mietkontenblätter <i class="mdi mdi-file-pdf"></i></a>
                            </td>
                            <td>
                                Mietkontenblätter aller Mieter
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a target="_blank"
                                   href="{{ route('web::einheiten::legacy', ['einheit_raus' => 'mieterliste_aktuell', 'objekt_id' => $objekt->OBJEKT_ID]) }}">Mieterkontakte
                                    <i class="mdi mdi-file-pdf"></i></a>
                            </td>
                            <td>
                                Kontaktliste aller Mieter
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a target="_blank"
                                   href="{{ route('web::objekte::legacy', ['objekte_raus' => 'mietaufstellung_j', 'objekt_id' => $objekt->OBJEKT_ID, 'jahr' => \Carbon\Carbon::parse('last year')->year]) }}">SOLL/IST
                                    <i class="mdi mdi-file-pdf"></i></a>
                            </td>
                            <td>
                                Mieten SOLL/IST kumuliert über das vorherige Jahr
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a target="_blank"
                                   href="{{ route('web::objekte::legacy', ['objekte_raus' => 'stammdaten_pdf', 'objekt_id' => $objekt->OBJEKT_ID]) }}">Stammdaten
                                    <i class="mdi mdi-file-pdf"></i></a>
                            </td>
                            <td>
                                Stammdaten des Objektes
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            @include('shared.cards.auftraege', ['auftraege' => $objekt->auftraege()->defaultOrder()->get(), 'type' => 'Objekt'])
        </div>
    </div>
@endsection