import React, {useContext} from 'react';
import {observer} from "mobx-react-lite";
import {Context} from "../index";
import Col from "react-bootstrap/Col";
import ListGroup from "react-bootstrap/ListGroup";

const TypeBar = observer(() => {
    const {device} = useContext(Context)
    return (
        <div className='d-flex justify-between flex-row ml-3'>
            {device.types.map(type =>
                <span
                    style={{color:'rgb(115,115,115)',cursor: 'pointer',fontSize:'14px'}}
                    className='mx-1'
                    active={type.id === device.selectedType.id}
                    onClick={() => device.setSelectedType(type)}
                    key={type.id}
                >
                    {type.name}
                </span>
            )}
        </div>
    );
});

export default TypeBar;
