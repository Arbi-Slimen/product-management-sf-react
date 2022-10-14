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
            </div>
        </div>
    )
}

export default Product;