import {Link} from 'react-router-dom'

function Header() {
    return (
        <header className="bg-dark py-5">
            <div className="container px-4 px-lg-5 my-5">
                <div className="text-center text-white">
                    <Link to=''>
                        <h1 className="display-4 fw-bolder">ATS</h1>
                        <p className="lead fw-normal text-white-50 mb-0">DIGITAL DEV</p>
                    </Link>
                </div>
            </div>
        </header>
    )
}

export default Header;