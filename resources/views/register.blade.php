<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link rel="stylesheet" href="{{asset('../css/styles.css')}}">
    <style>
        .form-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        
    </style>
</head>

<body>
    <header>
        <h1> Register </h1>
    </header>

    <main>
        @if(session('error'))
            <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 1rem; margin-bottom: 1rem; border-radius: 4px;">
                {{ session('error') }}
            </div>
        @endif

        <button onclick="openRegisterAsDonor()">Register as Donor</button> 
        <button onclick="openRegisterAsVolunteer()">Register as Volunteer</button> 

        <div style="width:400px; display: none;" id="register-as-donor" class="signup-container" >
            <h2>Register as Donor</h2>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <input type="hidden" name="role" value="donor">
                <div>
                    <label for="name"> Name: </label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <br>
                <div>
                    <label for="email"> Email: </label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <br>
                <div>
                    <label for="phone"> Phone: </label>
                    <input type="number" id="phone" name="phone" placeholder="Enter your phone number" value="{{ old('phone') }}" required>
                    @error('phone')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <br>
                <div>
                    <label for="location"> Location: </label>
                    <input type="text" id="location" name="location" placeholder="Enter your location" value="{{ old('location') }}" required>
                    @error('location')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <br>
                <div>
                    <label for="password"> Password: </label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    @error('password')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <br>
                <div>
                    <label for="password_confirmation"> Confirm Password: </label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
                </div>

                <br>
                <div class="form-buttons">
                    <button type="submit" class="submit-button">Register</button>
                    <button type="reset" class="reset-button">Reset</button>
                </div>
            </form>
            <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
        </div>

        <section class="form-container" style="display: none;" id="register-as-volunteer">
            <h2>Register as Volunteer</h2>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <input type="hidden" name="role" value="volunteer">
                <label for="name" style="font-weight: bold;">Full Name:</label>
                <input id="name" name="name" type="text" placeholder="Full Name" value="{{ old('name') }}" required>
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
                <br>

                <label for="phone" style="font-weight: bold;">Phone Number:</label>
                <input id="phone" name="phone" type="number" placeholder="Phone" value="{{ old('phone') }}" required>
                @error('phone')
                    <span class="error">{{ $message }}</span>
                @enderror
                <br>

                <label for="email"> Email: </label>
                <input type="email" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
                <br>            

                <label for="location" style="font-weight: bold;">Location:</label>
                <input id="location" name="location" type="text" placeholder="Enter your location" value="{{ old('location') }}" required>
                @error('location')
                    <span class="error">{{ $message }}</span>
                @enderror
                <br>

                <label for="availability" style="font-weight: bold;">Select your availability</label>
                <select name="availability" id="availability" required>
                    <option value="" disabled {{ old('availability') ? '' : 'selected' }}>Select availability</option>
                    <option value="week-end" {{ old('availability') == 'week-end' ? 'selected' : '' }}>Week-end</option>
                    <option value="7-days" {{ old('availability') == '7-days' ? 'selected' : '' }}>7-days</option>
                    <option value="Mon--Fri" {{ old('availability') == 'Mon--Fri' ? 'selected' : '' }}>Mon--Fri</option>
                </select>
                @error('availability')
                    <span class="error">{{ $message }}</span>
                @enderror
                <br>

                <label for="password" style="font-weight: bold;">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
                <br>

                <label for="password_confirmation" style="font-weight: bold;">Confirm Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
                <br>

                <label for="message" style="font-weight: bold;">Volunteer message:</label>
                <textarea id="message" name="message" placeholder="Why do you want to volunteer?" rows="4">{{ old('message') }}</textarea>

                <div class="form-buttons">
                    <button type="submit" class="submit-button">Register</button>
                    <button type="reset" class="reset-button">Reset</button>
                </div>
            </form>
            <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
        </section>
    </main>

    <script>
        function closeRegisterAsDonor(){
            document.getElementById("register-as-donor").style.display = "none";
        }

        function closeRegisterAsVolunteer(){
            document.getElementById("register-as-volunteer").style.display = "none";
        }

        function closeAllModals(){
            closeRegisterAsDonor();
            closeRegisterAsVolunteer();
        }

        function openRegisterAsDonor(){
            closeAllModals();
            document.getElementById("register-as-donor").style.display = "block";
        }

        function openRegisterAsVolunteer(){
            closeAllModals();
            document.getElementById("register-as-volunteer").style.display = "block";
        }

        // Prevent default form submission and submit via POST
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                this.submit();
            });
        });
    </script>

</body>

</html>