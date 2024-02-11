import React, { useContext, useEffect } from 'react';
import { Container } from "react-bootstrap";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import TypeBar from "../components/TypeBar";
import BrandBar from "../components/BrandBar";
import DeviceList from "../components/DeviceList";
import { observer } from "mobx-react-lite";
import { Context } from "../index";
import { fetchBrands, fetchDevices, fetchTypes } from "../http/deviceAPI";
import Pages from "../components/Pages";

const Shop = observer(() => {
    const { device } = useContext(Context)

    useEffect(() => {
        fetchTypes().then(data => device.setTypes(data))
        fetchBrands().then(data => device.setBrands(data))
        fetchDevices(null, null, 1, 2).then(data => {
            device.setDevices(data.rows)
            device.setTotalCount(data.count)
        })
    }, [])

    useEffect(() => {
        fetchDevices(device.selectedType.id, device.selectedBrand.id, device.page, 7).then(data => {
            device.setDevices(data.rows)
            device.setTotalCount(data.count)
        })
    }, [device.page, device.selectedType, device.selectedBrand,])

    return (
        <Container>
            <Row className="mt-2">
                <div
                    className='mt-4 d-flex flex-column align-items-center'
                    style={{
                        backgroundImage: 'url(./ayni13dt7ogetx5ynqev.png)',
                        backgroundSize: 'cover',
                        width: '100%',
                        height: '400px',
                        borderRadius: '10px'
                    }}>
                        <div style={{fontSize:'3.75rem'}}>Explore The Special Collection!</div>
                </div>
                <Col>


                    <DeviceList />
                    <Pages />
                </Col>
            </Row>
        </Container>
    );
});

export default Shop;
