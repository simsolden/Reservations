<x-app-layout>
    <x-slot name="header">
        <h2 class="px-12 font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fiche du spectacle ') }}{{ $show->title }}
        </h2>
    </x-slot>

    <div class="flex mb-4">
      <div class="w-1/4 px-12">
        <h2 class="py-5"><b class="text-2xl">Infos billeterie</b></h2>
        <p><strong>Prix:</strong> {{ $show->price }} €</p>

        @if(($show->bookable) && (empty($representations[0]->when)))
          <p><em>Précommande uniquement</em></p>
        @elseif($show->bookable)
          <p><em>Réservable</em></p>
        @else
          <p><em>Non réservable</em></p>
        @endif

        <h2 class="py-5"><b class="text-2xl">Liste des représentations</b></h2>
        @if($show->representations->count()>0)
            <ul>

            @foreach ($show->representations as $item)
                <li class="list-disc"><b>Date</b> : {{ !empty($item->when) ? $item->when : "non définie" }}</li>
                <li class="list-none"><b>Salle</b> : {{ !empty($representations[0]->location_id) ? $item->location->designation : "Non définie" }}</li>  <!--TODO-->

                @if($show->bookable == true)
                  <li><b>{{ !empty($representations[0]->location_id) ? "Places" : "Précommandes" }}</b> : <b @if($item->places < 11) class="text-red-600" @endif></b>
                  {{ $item->places }}
                  </li>
                @else
                  <li><b>Places</b> : Bientôt disponnibles</li>
                @endif

            @endforeach
            </ul>
        @elseif($show->location_id != NULL)

        <ul>
          <li><b>Salle</b>: {{ $show->location->designation }}</li>
        </ul>

        @else
          <p class="text-gray-600">Aucune représentation</p>
        @endif

        <h2 class="py-5"><b class="text-2xl">Liste des artistes</b></h2>
        <p><strong>Auteur:</strong>
        @foreach ($collaborateurs['auteur'] as $auteur)
            {{ $auteur->firstname }}
            {{ $auteur->lastname }}@if($loop->iteration == $loop->count-1) et
            @elseif(!$loop->last), @endif
        @endforeach
        </p>
        <p><strong>Metteur en scène:</strong>
        @foreach ($collaborateurs['scénographe'] as $scenographe)
            {{ $scenographe->firstname }}
            {{ $scenographe->lastname }}@if($loop->iteration == $loop->count-1) et
            @elseif(!$loop->last), @endif
        @endforeach
        </p>
        <p><strong>Distribution:</strong>
        @foreach ($collaborateurs['comédien'] as $comedien)
            {{ $comedien->firstname }}
            {{ $comedien->lastname }}@if($loop->iteration == $loop->count-1) et
            @elseif(!$loop->last), @endif
        @endforeach
        </p>

      </div>
      <div class="w-2/4 px-10 flex justify-center">
        <div>
          <h1 class="text-4xl font-black mb-5">{{ $show->title }}</h1>
          <P>{{ $show->description }}</P>
          @if($show->poster_url)
            <img class="object-contain shadow-md" src="{{ asset('images/'.$show->poster_url) }}" alt="{{ $show->title }}" min-width="200">
          @else
            <canvas width="200" height="100" style="border:1px solid #000000;"></canvas>
          @endif
        </div>
      </div>
      <div class="w-1/4">
        <div class="pl-5 pb-10">
          <p class="my-5 text-2xl font-black"><b>Lieu de représentation</b></p>
          @if($show->location_id != NULL)
            <p><b>Lieu :</b> {{ $show->location->designation }}</p>
          @else
            <p><b>Lieu :</b> Non défini</p>
          @endif
        </div>

          @if($show->bookable)
          <div>
          <div class="bg-white rounded-xl p-5 shadow-md">
          <p class="my-5 text-3xl font-black"><b>Réserver des places</b></p>



          <form id="frmPlace" name="frmPlace" action="{{ route('show_select_place', $show->id) }}" method="get">
              @method("GET")
              @csrf
              <select id="selectPlace" class="mb-3" type="select" id="date" name="place">
                @if(!isset($dates))
                    <option value="">Choisir une salle</option>
                    @foreach ($show->representations as $item)
                        <option value="{{ !empty($item->location->designation) ? $item->location->designation : "" }}">{{ !empty($item->location->designation) ? $item->location->designation : "Non définie" }}</option>
                    @endforeach
                @else
                    @foreach ($show->representations as $item)
                        <option value="{{ !empty($place) ? $place : "" }}">{{ !empty($place) ? $place : "" }}</option>
                        <option value="{{ (!empty($item->location->designation) && ($item->location->designation != $place)) ? $item->location->designation : "" }}">{{ (!empty($item->location->designation) && ($item->location->designation != $place)) ? $item->location->designation : "" }}</option>
                    @endforeach
                @endif
                <input type="hidden" id="showSelected" name="showSelected" value="{{ $show->id }}"><br>
                <button type="submit" class="hidden mt-5 bg-red-800 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md">
                    date
                </button>
              </select>
          </form>



          <form id="frmReservation" name="frmReservation" action="{{ route('show_booking', $show->id) }}" method="post">
            @method("POST")
            @csrf
              <select class="mb-3" type="select" id="date" name="date">


                      @if(isset($dates))
                        @foreach($dates as $date)
                            <option value="{{ $date }}">{{ $date }}</option>
                        @endforeach

                      @else
                            <option value="">Choisir une date</option>
                      @endif
              </select><br>
              <label class="pl-1" for="quantity">Quantité :</label>
              <input type="number" id="quantity" name="quantity" min="1" max="50" placeholder="0"><br>
              <button type="submit" class="mt-5 bg-red-800 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md">
                  Réserver
              </button>
          </form>



          @else
            <p><em class="text-red-700 pl-5 text-2xl">Non réservable</em></p>
          @endif

          @if(Session::has('message'))
            <p class="text-red-700">{{ Session::get('message') }}</p>
          @endif

          @if($show->bookable)
            <div class="mt-10">
              <a href={{ route('show') }} class="px-4 py-2 bg-gray-600 text-center rounded-md text-white text-sm focus:border-transparent hover:bg-gray-800">Retour vers les spectacles</a>
            </div>
          @else
            <div class="mt-10 ml-5">
              <a href={{ route('show') }} class="px-4 py-2 bg-gray-600 text-center rounded-md text-white text-sm focus:border-transparent hover:bg-gray-800">Retour vers les spectacles</a>
            </div>
          @endif
      </div>
    </div>
    <script src="{{ asset('js/selectShow.js') }}" defer></script>
</x-app-layout>

