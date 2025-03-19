<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 text-center">
            {{ __('Liste des DVDs') }}
        </h2>
    </x-slot>

    <div class="py-8">
            <div style="display: flex; flex-direction: column; width: 100%;">
                <!-- Conteneur principal avec flex -->
                <div style="display: flex; flex-direction: row; width: 100%;">
                    <!-- Barre de recherche -->
                    <div class="search-container" style="flex: 80%;margin-left:20px;">
                        <input type="search" id="searchQuery" class="search-input" placeholder="Rechercher un film..." style="width: 100%;">
                        <button class="search-button">
                            <img src="{{ asset('img/loupe.png') }}" alt="Search" class="search-icon">
                        </button>
                    </div>
                    <!-- Bouton d'ajout -->
                    <div style="flex: 20%; display: flex; align-items: center; justify-content: center;">
                        <a href="{{ route('films.create') }}" class="add-button" style="height: 40px;">
                            ➕ Ajouter un film
                        </a>
                    </div>
                </div>
            </div>

    </div>

            <!-- Liste des films -->
            @if (isset($films) && count($films) > 0)
                <ol role="list" class="film-grid">
                    @foreach ($films as $index => $film)
                        <li class="film-card">
                            <!-- Menu contextuel -->
                            <div class="menu-container">
                                <button onclick="toggleMenu({{ $film['filmId'] }})" class="menu-button">
                                    ☰
                                </button>
                                <ul id="dropdownMenu-{{ $film['filmId'] }}" class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('films.edit', $film['filmId']) }}" class="dropdown-item">
                                            ✏ Modifier
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('films.destroy', ['id' => $film['filmId']]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-red-600">
                                                ❌ Supprimer
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            <!-- Numéro du film -->
                            <div class="film-number">{{ $index + 1 }}</div>

                            <!-- Titre du film -->
                            <div class="film-title">
                                <strong>Titre :</strong> 
                                <a href="{{ route('detail', ['filmId' => $film['filmId']]) }}" class="film-link">
                                    {{ $film['title'] ?? 'Titre inconnu' }}
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ol>
            @else
                <p class="text-center text-gray-500">Aucun film disponible.</p>
            @endif
        </div>
    </div>

    <!-- Script pour la recherche en direct -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("searchQuery");
            const filmCards = document.querySelectorAll(".film-card");

            searchInput.addEventListener("input", function() {
                const searchValue = searchInput.value.toLowerCase();

                filmCards.forEach(card => {
                    const title = card.querySelector(".film-title").textContent.toLowerCase();
                    
                    if (title.includes(searchValue)) {
                        card.style.display = "block";
                    } else {
                        card.style.display = "none";
                    }
                });
            });
        });

        function toggleMenu(filmId) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                if (menu.id !== `dropdownMenu-${filmId}`) {
                    menu.classList.remove('active');
                }
            });

            const menu = document.getElementById(`dropdownMenu-${filmId}`);
            menu.classList.toggle('active');
        }

        document.addEventListener('click', function(event) {
            if (!event.target.closest('.menu-container')) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.remove('active');
                });
            }
        });
    </script>

    <!-- Styles améliorés -->
    <style>
        /* Grille des films */
        .film-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            padding: 0;
            list-style: none;
        }

        /* Carte de film */
        .film-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            transition: transform 0.2s;
        }

        .film-card:hover {
            transform: translateY(-5px);
        }

        .film-number {
            width: 2.5rem;
            height: 2.5rem;
            background: black;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .film-title {
            margin-bottom: 1rem;
        }

        .film-link {
            color: #2563eb;
            text-decoration: none;
            font-weight: bold;
        }

        .film-link:hover {
            text-decoration: underline;
        }

        /* Menu contextuel */
        .menu-container {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .menu-button {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            min-width: 120px;
            z-index: 50;
        }

        .dropdown-menu.active {
            display: block;
        }

        .dropdown-item {
            display: block;
            padding: 8px 12px;
            color: #374151;
            text-decoration: none;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background: #f3f4f6;
        }

        /* Barre de recherche */
        .search-container {
            display: flex;
            align-items: center;
            width: 300px;
            margin: 10px auto;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 25px;
            background: #fff;
        }

        .search-input {
            flex: 1;
            border: none;
            padding: 12px 16px;
            outline: none;
        }

        .search-button {
            padding: 12px;
            background: none;
            border: none;
            cursor: pointer;
            color: #6b7280;
        }

        .search-icon {
            width: 20px;
            height: 20px;
        }

        /* Bouton Ajouter */
        .add-button {
            padding: 10px 16px;
            font-size: 14px;
            font-weight: 500;
            color: #fff;
            background:rgb(37, 129, 235);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .add-button:hover {
            background:rgb(78, 90, 194);
        }
    </style>
</x-app-layout>
