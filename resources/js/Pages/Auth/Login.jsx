import { useState } from "react";
import { Head, Link, useForm } from "@inertiajs/react";

export default function Login() {
    const { data, setData, post, processing, errors } = useForm({
        email: "",
        password: "",
    });

    const [isRegister, setIsRegister] = useState(false);

    const handleLoginSubmit = (e) => {
        e.preventDefault();
        post(route("login"));
    };

    const handleRegisterSubmit = (e) => {
        e.preventDefault();
        post(route("register"));
    };

    return (
        <>
            <Head title="Login" />
            <div className="background-image"></div>
            <div className="background-overlay"></div>
            
            <header className="header">
                <nav className="navbar">
                    <Link href="/">Home</Link>
                    <Link href="#about">About</Link>
                    <Link href="#contactSection">Contact</Link>
                </nav>
                <div className="search-bar">
                    <h2 className="logo text-white">
                        <img src="/images/coe-logo.png" alt="COE Logo" className="coe-image" />
                        <span id="collegeText">College of Engineering</span>
                    </h2>
                </div>
            </header>

            <div className="container">
                <div className="item">
                    <h2 className="logo">
                        <img src="/images/mmsu-logo.png" alt="MMSU Logo" className="mmsu-image" />
                        <span className="mmsu-text">Mariano Marcos State University</span>
                    </h2>
                    <div className="text-item">
                        <h2>Welcome!<br /><span>Computer Engineering Alumni</span></h2>
                        <p>Please login to continue</p>
                    </div>
                </div>

                <div className="login-section">
                    {!isRegister ? (
                        <div className="form-box login">
                            <form onSubmit={handleLoginSubmit}>
                                <h2>Sign In</h2>
                                <div className="input-box">
                                    <span className="icon"><i className="bi bi-envelope"></i></span>
                                    <input 
                                        type="email" 
                                        value={data.email}
                                        onChange={e => setData('email', e.target.value)}
                                        required
                                    />
                                    <label>Email</label>
                                    {errors.email && <p className="error">{errors.email}</p>}
                                </div>
                                <div className="input-box">
                                    <span className="icon"><i className="bi bi-lock"></i></span>
                                    <input 
                                        type="password"
                                        value={data.password}
                                        onChange={e => setData('password', e.target.value)}
                                        required
                                    />
                                    <label>Password</label>
                                    {errors.password && <p className="error">{errors.password}</p>}
                                </div>
                                <button type="submit" className="btn" disabled={processing}>
                                    {processing ? 'Signing in...' : 'Sign In'}
                                </button>
                                <div className="create-account">
                                    <p>Create A New Account? 
                                        <button type="button" onClick={() => setIsRegister(true)} className="register-link">
                                            Sign Up
                                        </button>
                                    </p>
                                </div>
                            </form>
                        </div>
                    ) : (
                        <div className="form-box register">
                            <form onSubmit={handleRegisterSubmit}>
                                {/* Similar structure as login form with register fields */}
                                <button type="button" onClick={() => setIsRegister(false)} className="login-link">
                                    Back to Login
                                </button>
                            </form>
                        </div>
                    )}
                </div>
            </div>
        </>
    );
}
