@php
    $feedbackCategories = [
        ['name' => 'Food Quality', 'icon' => 'fa-bowl-food'],
        ['name' => 'Delivery Speed', 'icon' => 'fa-truck-fast'],
        ['name' => 'Packaging', 'icon' => 'fa-box-open'],
        ['name' => 'Customer Service', 'icon' => 'fa-headset'],
        ['name' => 'App Experience', 'icon' => 'fa-mobile-screen-button'],
        ['name' => 'Payment Issues', 'icon' => 'fa-credit-card'],
    ];

    $satisfactionRatings = [
        1 => 'Poor',
        2 => 'Fair',
        3 => 'Good',
        4 => 'Great',
        5 => 'Excellent',
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>Feedback | {{ config('app.name', 'Micaller') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
        <link href="{{ asset('css/customer/feedback.css') }}?v={{ filemtime(public_path('css/customer/feedback.css')) }}" rel="stylesheet" />
    </head>
    <body>
        <nav class="navbar navbar-expand-lg sticky-top site-nav">
            <div class="container">
                <a class="navbar-brand logo" href="{{ route('home') }}">
                    <span class="logo-mark"><i class="fa-solid fa-utensils"></i></span>
                    {{ config('app.name', 'Micaller') }}
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#feedbackNav" aria-controls="feedbackNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="feedbackNav">
                    <div class="navbar-nav ms-lg-3 me-lg-auto nav-links">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        <a class="nav-link" href="{{ route('menus') }}">Menus</a>
                        <a class="nav-link active" href="{{ route('feedback') }}">Feedback</a>
                        <a class="nav-link" href="{{ route('settings.profile') }}">Settings</a>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="ms-lg-auto nav-actions">
                        @csrf
                        <span class="role-pill">Customer</span>
                        <button type="submit" class="btn btn-soft">Log out</button>
                    </form>
                </div>
            </div>
        </nav>

        <main>
            <section class="feedback-hero">
                <div class="container">
                    <div class="row align-items-center g-5">
                        <div class="col-lg-6">
                            <span class="eyebrow"><i class="fa-solid fa-message"></i> Share your thoughts</span>
                            <h1>Tell us about your experience.</h1>
                            <p>Your comments help Micaller improve food quality, service, and ordering flow for your next visit.</p>

                            <div class="feedback-grid hero-feedback-grid">
                                <button
                                    type="button"
                                    class="info-card feedback-topic"
                                    data-category="Food Quality"
                                    data-placeholder="Tell us what happened with food taste, freshness, serving size, or quality."
                                >
                                    <span class="info-icon"><i class="fa-solid fa-bowl-food"></i></span>
                                    <h2>Meal quality</h2>
                                    <p>Share notes about taste, serving size, packaging, or freshness.</p>
                                </button>

                                <button
                                    type="button"
                                    class="info-card feedback-topic"
                                    data-category="Delivery Speed"
                                    data-placeholder="Tell us what happened with delivery or preparation time."
                                >
                                    <span class="info-icon warning"><i class="fa-solid fa-clock"></i></span>
                                    <h2>Order timing</h2>
                                    <p>Let us know how pickup, delivery, or preparation time felt.</p>
                                </button>

                                <button
                                    type="button"
                                    class="info-card feedback-topic"
                                    data-category="App Experience"
                                    data-placeholder="Tell us what you liked, what you want to reorder, or what felt hard to find."
                                >
                                    <span class="info-icon accent"><i class="fa-solid fa-heart"></i></span>
                                    <h2>Favorites</h2>
                                    <p>Tell the kitchen what you want to see more often on the menu.</p>
                                </button>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <form class="feedback-card" method="POST" action="{{ route('feedback.store') }}">
                                @csrf
                                <div class="feedback-card-head">
                                    <span class="feedback-icon"><i class="fa-solid fa-pen-to-square"></i></span>
                                    <div>
                                        <span class="section-kicker">Feedback menu</span>
                                        <h2>Write your feedback</h2>
                                    </div>
                                </div>

                                @if (session('status'))
                                    <div class="feedback-toast" role="status" aria-live="polite">
                                        <i class="fa-solid fa-circle-check"></i>
                                        <span>{{ session('status') }}</span>
                                    </div>
                                @endif

                                <fieldset class="category-fieldset">
                                    <legend class="form-label">Category</legend>
                                    <div class="category-options">
                                        @foreach ($feedbackCategories as $category)
                                            <label class="category-option">
                                                <input
                                                    type="radio"
                                                    name="category"
                                                    value="{{ $category['name'] }}"
                                                    @checked(old('category') === $category['name'])
                                                >
                                                <span class="category-option-body">
                                                    <span class="category-option-icon"><i class="fa-solid {{ $category['icon'] }}"></i></span>
                                                    <span>{{ $category['name'] }}</span>
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('category')
                                        <div class="feedback-error">{{ $message }}</div>
                                    @enderror
                                </fieldset>

                                <fieldset class="rating-fieldset">
                                    <legend class="form-label">Satisfaction rating</legend>
                                    <div class="rating-options" aria-label="Customer satisfaction rating">
                                        @foreach ($satisfactionRatings as $rating => $label)
                                            <label class="rating-option">
                                                <input
                                                    type="radio"
                                                    name="rating"
                                                    value="{{ $rating }}"
                                                    @checked((int) old('rating') === $rating)
                                                >
                                                <span class="rating-option-body">
                                                    <i class="fa-solid fa-star"></i>
                                                    <strong>{{ $rating }}</strong>
                                                    <small>{{ $label }}</small>
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('rating')
                                        <div class="feedback-error">{{ $message }}</div>
                                    @enderror
                                </fieldset>

                                <div class="message-label-row">
                                    <label for="message" class="form-label">Message</label>
                                    <span class="character-counter" id="message-counter" aria-live="polite">0/1000</span>
                                </div>
                                <textarea id="message" name="message" class="feedback-textarea @error('message') is-invalid @enderror" rows="8" maxlength="1000" aria-describedby="message-counter" placeholder="Type your feedback here...">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="feedback-error">{{ $message }}</div>
                                @enderror

                                <button type="submit" class="btn feedback-submit">
                                    <span class="submit-ready">
                                        <i class="fa-solid fa-paper-plane"></i>
                                        Submit feedback
                                    </span>
                                    <span class="submit-loading">
                                        <i class="fa-solid fa-spinner"></i>
                                        Sending...
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

        </main>

        <footer class="site-footer">
            <div class="container d-flex flex-column flex-md-row justify-content-between gap-3">
                <span>&copy; {{ date('Y') }} {{ config('app.name', 'Micaller') }}. Fresh food, fast.</span>
                <div class="footer-links">
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('menus') }}">Menus</a>
                    <a href="{{ route('feedback') }}">Feedback</a>
                    <a href="{{ route('settings.profile') }}">Settings</a>
                </div>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            const form = document.querySelector('.feedback-card');
            const message = document.querySelector('#message');
            const counter = document.querySelector('#message-counter');
            const submitButton = document.querySelector('.feedback-submit');
            const topics = document.querySelectorAll('.feedback-topic');

            const updateCounter = () => {
                if (!message || !counter) {
                    return;
                }

                counter.textContent = `${message.value.length}/1000`;
            };

            const activateTopic = (topic, shouldFocusMessage = true) => {
                const category = topic.dataset.category;
                const placeholder = topic.dataset.placeholder;
                const categoryInput = document.querySelector(`input[name="category"][value="${category}"]`);

                if (categoryInput) {
                    categoryInput.checked = true;
                }

                if (message && placeholder) {
                    message.placeholder = placeholder;

                    if (shouldFocusMessage) {
                        message.focus();
                    }
                }

                topics.forEach((item) => {
                    item.classList.toggle('is-selected', item === topic);
                    item.setAttribute('aria-pressed', item === topic ? 'true' : 'false');
                });
            };

            topics.forEach((topic) => {
                topic.setAttribute('aria-pressed', 'false');

                topic.addEventListener('click', () => {
                    activateTopic(topic);
                });
            });

            document.querySelectorAll('input[name="category"]').forEach((input) => {
                input.addEventListener('change', () => {
                    const matchingTopic = document.querySelector(`.feedback-topic[data-category="${input.value}"]`);

                    if (matchingTopic) {
                        activateTopic(matchingTopic, false);
                    }
                });
            });

            const checkedCategory = document.querySelector('input[name="category"]:checked');

            if (checkedCategory) {
                const matchingTopic = document.querySelector(`.feedback-topic[data-category="${checkedCategory.value}"]`);

                if (matchingTopic) {
                    activateTopic(matchingTopic, false);
                }
            }

            if (message) {
                updateCounter();
                message.addEventListener('input', updateCounter);
            }

            if (form && submitButton) {
                form.addEventListener('submit', () => {
                    submitButton.classList.add('is-loading');
                    submitButton.disabled = true;
                    submitButton.setAttribute('aria-busy', 'true');
                });
            }
        </script>
    </body>
</html>
