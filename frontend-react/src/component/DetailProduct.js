import {useFetch} from "../api/api";
import React from "react";
import {useParams} from 'react-router-dom'

function DetailProduct() {
    const {id} = useParams()
    const {data, isLoading, error} = useFetch(`http://127.0.0.1:8000/api/product/${id}`, [id])

    if (error) {
        return <span>Oups problème de fetch</span>
    }

    return (
        <section className="py-5">
            <div className="container px-4 px-lg-5 my-5">
                <div className="row gx-4 gx-lg-5 align-items-center">
                    <div className="col-md-6"><img className="card-img-top mb-5 mb-md-0"
                                                   src={data.imageUrl}/>
                    </div>
                    <div className="col-md-6">
                        <h1 className="display-5 fw-bolder">{data.productName}</h1>
                        <div className="fs-5 mb-5">
                            <div>Price: {data.price} $</div>
                            <span>AverageScore: {data.averageScore}</span>
                        </div>
                        <p className="lead">{data.description}</p>
                    </div>
                </div>
            </div>
        </section>
    )

}

export default DetailProduct