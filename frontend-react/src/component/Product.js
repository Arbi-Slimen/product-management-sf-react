import {Link} from 'react-router-dom'

function Product({id, productName, price, imageUrl, averageScore, category}) {

    return (
        <div className="col mb-5">
            <div className="card h-100">
                <img className="card-img-top" src={imageUrl}
                     alt={productName}/>
                <div className="card-body p-4">
                    <div className="text-center">
                        <h5 className="fw-bolder">{productName}</h5>
                        <h6>Price {price} $</h6>
                        <h6>Average score: {averageScore}</h6>
                        <h6>Category: {category}</h6>
                    </div>
                </div>
                <div className="card-footer p-4 pt-0 border-top-0 bg-transparent">
                    <div className="text-center"><Link to={`/show/${id}`}>
                        <button className='btn btn-outline-dark mt-auto'>Detail</button>
                    </Link></div>
                </div>
            </div>
        </div>
    )
}

export default Product;