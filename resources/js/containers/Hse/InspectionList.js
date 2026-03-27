import React, {useState,useEffect} from "react";
import ReactDOM from "react-dom";
import Options from "../../components/Form/Options";
import OptionGroup from "../../components/Form/OptionGroup";
import _ from "lodash";

function InspectionItem({ 
  inspection, 
  datasets = {
    'karyawan':[],
    'location':[]
  }  
}, ...otherProps){

  const [] = useState([]);
  let itemSets = {'karyawan':[],'location':[]};
  return (
    <React.Fragment>
      <div className="form-row my-2">
        <label className="font-weight-bold">{_.capitalize(inspection.name)}</label>
      </div>

      {inspection.properties.map((item,id) => {        
        
        if(item.dataset){          

          for(var prop in datasets){
            if( datasets.hasOwnProperty(prop) && otherProps[item.dataset] ){
              console.log(prop);
              itemSets[prop] = otherProps[item.dataset];
            }
          }

        }

        return (
          <div key={`inspection-item-${id}`} className="row my-2 ml-4">                
            <div className="col-md-3 col-12">
              <label className="font-weight-bold font-weight-normal-md">
                { item.name }
              </label>
            </div>
            <div className="col-md-3 col-12">
              
              {item.input.type == 'option' && <Options data={itemSets[item.dataset]} />}
              {item.input.type == 'optionGroup' && <OptionGroup name={item.id} options={defaultOptions} />}
              {(item.input.type !== 'option' && item.input.type !== 'optionGroup') && <input type="text" className="form-control" />}                
              
            </div>
          </div>
        )
      })}

    </React.Fragment>
  )
}

const defaultOptions = [{
  'label':'baik',
  'value':'1'
  },
{
  'label':'rusak',
  'value':'2'
}];

function InspectionList({ inspectionItems, equipmentCategory, equipment, location }){
    
  const [selectedEquipmentCategory, setEquipmentCategory] = useState("");
  const [selectedAssetCode, setAssetCode] = useState("");
  const [selectedLocation, setLocation] = useState("");
  const [assetCodes, putAssetCodes] = useState([]);
  const [assetNames, putAssetNames] = useState([]);  

  const filterEquipmentByCategory = () => {
    putAssetCodes([]);

    let tempAssetCodes = _.filter(JSON.parse(equipment), (o) => o.equipment_category_id == selectedEquipmentCategory);
    let moreAssets = _.uniqBy(tempAssetCodes, e => e.code)
    putAssetCodes(moreAssets)

    /*
    [{
      "id":1,
      "equipment_category_id":1,
      "location_id":1,
      "brand_id":null,
      "code":"LATUMBI 01",
      "name":"LATUMBI 01",
      "desc":"ukuran kapal 230 feet x 64 feet x 14 feet",
      "equipment_status_id":1,
      "chassis_no":null,
      "engine_no":null,
      "yop":2011,
      "deleted_at":null,
      "created_at":"2021-10-16T16:36:24.000000Z",
      "updated_at":"2021-10-16T16:36:24.000000Z",
      "category":{
        "id":1,
        "name":"barge",
        "description":null,
        "deleted_at":null
      }
    }]
    */
  }

  const filterEquipmentByCode = () => {
    putAssetNames([]);
    putAssetNames(_.filter(JSON.parse(equipment), (o) => o.code == selectedAssetCode))
  }

  useEffect(() => {
    // filter asset code berdasarkan category
    filterEquipmentByCategory();
  }, [selectedEquipmentCategory])

  useEffect(() => {
    // filter asset name based on asset code
    filterEquipmentByCode();
  }, [selectedAssetCode])

  return (
    <div className="iq-card">
      <div className="iq-card-body">
        <div className="row">
          <div className="col-sm-8">
            <h4 className="card-title text-primary">
              <span className="ri-chat-check-line pr-2"></span>P2H
            </h4>
            
          </div>
          <div className="col-sm-4 text-right">
              {/* <button id="createProjectBtn" type="button" onClick={onClickButton('Hi Bos')} className="btn btn-lg mb-3 btn-success rounded-pill font-weight-bold" data-toggle="modal" data-backdrop="static" data-target="#createProjectModal">
                <i className="las la-plus"></i>New P2H
              </button> */}
          </div>
        </div>
        <hr/>
        <div className="row">
          <div className="col-12 mt-2">
            <div className="form-row">
              <div className="col-md-3 col-12">
                <div className="form-group">
                  <label>Assignment No</label>
                  <input type="text" id="assignment_no" name="assignment_no" value="" className="form-control" placeholder="" />
                </div>
              </div>
              <div className="col-md-3 col-12">
                <div className="form-group">                  
                  <Options 
                    label="Location" 
                    data={JSON.parse(location)}
                    value={selectedLocation}
                    onChange={e=>setLocation(e.target.value)}
                    optionValue="id"
                    optionLabel="location_name" />
                </div>
              </div>
            </div>

            <div className="form-row">
              <div className="col-md-3 col-12">
                <div className="form-group">
                  <Options 
                    label="Asset" 
                    data={JSON.parse(equipmentCategory)} 
                    value={selectedEquipmentCategory} 
                    onChange={(e) => setEquipmentCategory(e.target.value)} />
                </div>
              </div>
              <div className="col-md-3 col-12">
                <div className="form-group">                  
                  <Options 
                    label="Asset Code" 
                    data={assetCodes}
                    value={selectedAssetCode}
                    onChange={(e)=>setAssetCode(e.target.value)}
                    optionValue="code"
                    optionLabel="code" />
                </div>
              </div>
              <div className="col-md-3 col-12">
                <div className="form-group">                  
                  <Options 
                    label="Asset Name" 
                    data={assetNames}                     
                    optionLabel="name" />
                </div>
              </div>
            </div>

            <div className="form-row mt-2">
              <label className="font-weight-bold">Item Category</label>
            </div>

            <hr/>

            {JSON.parse(inspectionItems).length > 0 && JSON.parse(inspectionItems)
              .map((inspection,index)=>(
                <InspectionItem 
                  key={`inspection-${index}`} 
                  inspection={inspection}
                  location={JSON.parse(location)} />
            ))}
            
          </div>
        </div>
      </div>
    </div>
  )
}

export default InspectionList;
if(document.getElementById('inspection-list')){
  const element = document.getElementById('inspection-list');
  const props = Object.assign({}, element.dataset);
  ReactDOM.render(<InspectionList {...props} />, document.getElementById('inspection-list'));
} else {
  console.log('DOM not exist')
}