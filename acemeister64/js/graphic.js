const rootStyles = getComputedStyle(document.documentElement);

function cVar(color) {
  return rootStyles.getPropertyValue(color).trim();
}

const canvas = document.getElementById("course-done");
const ctx = canvas.getContext("2d");

const size = canvas.height;
const center = size / 2;

const outerRadius = size / 2;
const innerRadius = outerRadius * 0.4;

const totalAngle = Math.PI * 2 * 0.9;
const startAngle = Math.PI / 2 + (Math.PI * 2 - totalAngle) / 2;

const stripeCount = 3;
const stripeThickness = (outerRadius - innerRadius) / stripeCount;
const colors = [cVar("--cherry"), cVar("--apple"), cVar("--mint")];

const borderSize = 1;

function drawArcSegment(rOuter, rInner, start, end, color) {
  ctx.beginPath();
  ctx.arc(center, center, rOuter, start, end);
  ctx.arc(center, center, rInner, end, start, true);
  ctx.closePath();
  ctx.fillStyle = color;
  ctx.fill();
}

function drawBackgroundArc() {
  drawArcSegment(
    outerRadius,
    outerRadius - 3 * stripeThickness,
    startAngle,
    startAngle + totalAngle,
    cVar("--raisin"),
  );
}

function drawProgress(progress) {
  const progressAngle = startAngle + totalAngle * progress;

  for (let i = 0; i < stripeCount; i++) {
    const rOuter = outerRadius - i * stripeThickness;
    const rInner = rOuter - stripeThickness;
    drawArcSegment(rOuter, rInner, startAngle, progressAngle, colors[i]);
  }
}

function render(progress) {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  drawBackgroundArc();
  drawProgress(progress);

  const percent = Math.round(progress * 100) + "%";
  ctx.font = "200px 'Roboto Slab', serif";
  ctx.textAlign = "center";
  ctx.textBaseline = "middle";
  ctx.fillStyle = cVar("--raisin");
  ctx.fillText(percent, center, center);
}
